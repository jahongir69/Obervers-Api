<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'name' => 'required|string|min:5|max:255',
            'username' => 'required|string|min:3|max:255|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    
    public function messages(): array
    {
        return [
            'name.required' => 'Ism maydoni majburiy.',
            'name.min' => 'Ism kamida 5 ta belgidan iborat bo‘lishi kerak.',
            'username.required' => 'Foydalanuvchi nomi majburiy.',
            'username.min' => 'Foydalanuvchi nomi kamida 3 ta belgi bo‘lishi kerak.',
            'username.unique' => 'Bunday username allaqachon mavjud.',
            'email.required' => 'Email maydoni majburiy.',
            'email.email' => 'Email noto‘g‘ri formatda.',
            'email.unique' => 'Bunday email allaqachon ro‘yxatdan o‘tgan.',
            'password.required' => 'Parol maydoni majburiy.',
            'password.min' => 'Parol kamida 6 ta belgidan iborat bo‘lishi kerak.',
            'password.confirmed' => 'Parollar bir-biriga mos kelmadi.',
            'avatar.image' => 'Avatar faqat rasm fayli bo‘lishi kerak.',
            'avatar.mimes' => 'Avatar faqat jpeg, png, jpg, gif formatlarida bo‘lishi mumkin.',
            'avatar.max' => 'Avatar hajmi 2MB dan oshmasligi kerak.',
        ];
    }
}
