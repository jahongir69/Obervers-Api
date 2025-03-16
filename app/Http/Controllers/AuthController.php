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
    
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'avatar' => $request->file('avatar') ? $request->file('avatar')->store('avatars') : null,
        ]);

        
        event(new UserRegistered($user));

        return response()->json(['message' => 'Foydalanuvchi muvaffaqiyatli ro‘yxatdan o‘tdi! Emailingizni tasdiqlang!'], 201);
    }


    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Email yoki parol noto‘g‘ri!'], 401);
        }

        $token = Auth::user()->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Tizimga muvaffaqiyatli kirdingiz',
            'token' => $token
        ], 200);
    }


    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Tizimdan chiqdingiz'], 200);
    }
}
