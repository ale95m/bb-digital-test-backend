<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Http\Responses\SendResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);
        $credentials = request(['email', 'password']);
        if (Auth::attempt($credentials)) {
            /** @var User $user */
            $user = Auth::user();
            $token = $user->getToken();
            return SendResponse::success($token);
        } else {
            return SendResponse::error(trans('auth.failed'), 401);
        }
    }

    function logout(Request $request): \Illuminate\Http\JsonResponse
    {
        /** @var User $user */
        $user = $request->user();
        $user->removeToken();
        return SendResponse::success('logout');
    }
}
