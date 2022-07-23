<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthSignupRequest;
use App\Models\User;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class AuthController extends Controller
{
    public function login(AuthLoginRequest $request)
    {
        $attempt = auth()->attempt($request->validated());
        if ($attempt) {
            $user = User::where('email', $request->input('email'))->first();
            $token = $user->createToken('')->accessToken;

            return response()->json([
                'token' => $token,
            ]);
        }

        throw new UnauthorizedHttpException('');
    }

    public function signup(AuthSignupRequest $request)
    {
        $user = User::create($request->validated());
        $token = $user->createToken('')->accessToken;
        return response()->json($user->toArray() + ['token' => $token], Response::HTTP_CREATED);
    }
}
