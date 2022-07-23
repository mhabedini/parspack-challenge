<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthSignupRequest;
use App\Services\AuthService;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class AuthController extends Controller
{
    public function login(AuthLoginRequest $request, AuthService $authService)
    {
        $attempt = auth()->attempt($request->validated());
        if (!$attempt) {
            throw new UnauthorizedHttpException('', 'Your credential is wrong');
        }

        if ($request->filled('email')) {
            $token = $authService->loginWithEmail($request->input('email'));
        } else {
            $token = $authService->loginWithUsername($request->input('username'));
        }
        return response()->json([
            'token' => $token,
        ]);
    }


    public function signup(AuthSignupRequest $request, AuthService $authService)
    {
        $user = $authService->signup($request->validated());
        $token = $authService->createToken($user);
        return response()->json($user->toArray() + ['token' => $token], Response::HTTP_CREATED);
    }
}
