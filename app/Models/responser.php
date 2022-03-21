<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Responser extends Model
{
    use HasFactory;

    /**
     * Return a success JSON response.
     *
     * @param  array|string  $data
     * @param  string  $message
     * @param  int|null  $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected static function success($data = null, $obj = '', $option = "standard", int $code = 200)
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
    /**
     * Return an error JSON response.
     *
     * @param  string  $message
     * @param  int  $code
     * @param  array|string|null  $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected static function standardSuccessController(string $obj = '', int $code = 200, $option)
    {
        $message = [
            "store" => ' registrado com sucesso',
            "update" => ' atualizado com sucesso',
            "destroy" => ' deletado com sucesso',
        ];
        return response(
            [
                'status' => 'Success',
                'message' => $obj . $message[$option],
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
    protected static function standardErrorController(string $obj = '', int $code, $option)
    {

        return response(
            [
                'status' => 'Error',
                'message' => $obj . ' nao encontrado',
            ],
            $code
        );
    }
}
