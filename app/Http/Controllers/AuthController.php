<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Models\Responser;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function codeValidation($cod, $is_invitation)
    {
        try {
            $user = User::where('token', 'like', substr($cod, 0, 3) . '%' . substr($cod, -3))->first();
            if ($user) {
                if ($is_invitation) {
                    return Responser::success(User::buildSimple($user), 'Usuário');
                }
                $date1 = Carbon::create($user->token_time);
                $date2 = Carbon::create(now());
                if ($date1->diffInHours($date2) <= 24) {
                    $user->token = null;
                    $user->update();
                    return Responser::success(User::build($user), 'Usuário');
                }
            } else {
                return Responser::error('codigo inválido ou expirado', 404);
            }
        } catch (Exception $e) {
            return Responser::error($e->getMessage(), 400);
        }
    }



    public function login(UserLoginRequest $request)
    {
        $payload = $request->all();

        $user = User::getUserDecripted($payload['email']);

        if ($user) {
            if (!Hash::check($payload['password'], $user->password)) {
                return Responser::error('Credenciais incorretas', 403);
            }

            $this->logout($user);
            Auth::login($user);

            return Responser::success([
                'user' => $user->build(),
                'token' => $user->createToken('API Token')->plainTextToken,
            ], 'Login');
        }

        return Responser::error('Usuário não cadastrado', 404);
    }


    public function updatePassword(User $user, $password)
    {

        if ($user) {
            $user->password = bcrypt($password);
            $user->update();
        }

        Auth::login($user);

        return Responser::success([
            'user' => User::build($user),
            'token' => $user->createToken('API Token')->plainTextToken,
        ], 'Senha', 'update');
    }



    public function logout(User $user)
    {
        if ($user) {

            $user->tokens()->delete();

            return Responser::success(null, 'Tokens Revoked');
        }
    }
}
