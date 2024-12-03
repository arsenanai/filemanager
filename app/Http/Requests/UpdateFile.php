<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFile extends FormRequest
{
    public function rules() : array
    {
        return [
            'title' => 'required',
        ];
    }
}