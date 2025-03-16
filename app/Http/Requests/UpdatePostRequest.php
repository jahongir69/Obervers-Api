<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string|min:5|max:255|unique:posts,title,' . $this->post->id,
            'description' => 'required|string|min:10',
        ];
    }
}
