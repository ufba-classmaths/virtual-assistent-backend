<?php

namespace App\Traits;

use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Api Responser Trait
|--------------------------------------------------------------------------
|
| This trait will be used for any response we sent to clients.
|
*/

trait ApiResponser
{
    /**
     * Return a success JSON response.
     *
     * @param  array|string  $data
     * @param  string  $obj
     * @param  string  $option
     * @param  int|null  $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected static function success($obj = '', $option = "standard", $data = null, int $code = 200,)
    {
        $message = [
            "standard" => "Operação realizada com sucesso",
            "store" => ' realizado(a) com sucesso',
            "update" => ' atualizado(a) com sucesso',
            "destroy" => ' excluido(a)  com sucesso',
        ];
        return response(
            [
                'status' => 'Success',
                'message' => $obj . ' ' . $message[$option],
                'data' => $data
            ],
            $code
        );
    }

    /**
     * Return an error JSON response.
     *
     * @param  string  $message
     * @param  int  $code
     * @param  array|string|null  $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected static function error(string $message = null, int $code, $data = null)
    {
        return response()->json(
            [
                'status' => 'Error',
                'message' => $message,
                'data' => $data
            ],
            $code
        );
    }
}
