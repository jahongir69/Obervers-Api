<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6',
        ];
    }


    public function messages(): array
    {
        return [
            'email.required' => 'Email maydoni majburiy.',
            'email.email' => 'Email noto‘g‘ri formatda.',
            'email.exists' => 'Bunday email tizimda mavjud emas.',
            'password.required' => 'Parol maydoni majburiy.',
            'password.min' => 'Parol kamida 6 ta belgidan iborat bo‘lishi kerak.',
        ];
    }
}
