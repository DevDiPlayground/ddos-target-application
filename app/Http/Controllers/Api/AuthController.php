<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        $data = $request->validated();

        if (auth()->attempt(['email' => $data['email'], 'password' => $data['password']])) {
            $user = User::where('email', $data['email'])->firstOrFail();

            $token = $user->createToken($data['token_name'])->plainTextToken;

            return response()->json([
                'success' => true,
                'data' => ['user' => $user, 'token' => $token],
            ]);
        }

        return response()->json([
            'success' => false,
            'error' => 'Invalid credentials',
        ], 401);
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['password'] = bcrypt($data['password']);

        $user = User::create($data);

        $token = $user->createToken($data['token_name'])->plainTextToken;

        return response()->json([
            'success' => true,
            'data' => ['user' => $user, 'token' => $token],
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $user = Auth::user();

        if ($user) {
            $user->tokens()->delete();
            Session::flush();

            return response()->json([
                'success' => true,
                'data' => 'Logged out successfully',
            ]);
        }

        return response()->json([
            'success' => false,
            'error' => 'Unauthorized',
        ], 401);
    }
}
