<?php

namespace App\Http\Controllers;

use App\Events\UserRegistered;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Ro‘yxatdan o‘tish
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new UserRegistered($user)); // Eventni ishga tushiramiz

        return response()->json(['message' => 'Ro‘yxatdan o‘tish muvaffaqiyatli. Emailingizni tasdiqlang!'], 201);
    }

    // Kirish
    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Login yoki parol noto‘g‘ri'], 401);
        }

        $token = Auth::user()->createToken('auth_token')->plainTextToken;

        return response()->json(['message' => 'Tizimga muvaffaqiyatli kirdingiz', 'token' => $token], 200);
    }

    // Chiqish
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Tizimdan chiqdingiz'], 200);
    }
}
