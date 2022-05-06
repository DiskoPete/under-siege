<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateSiegeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'concurrent' => 'required|max:50',
            'duration' => 'required|max:60',
            'target' => 'required|url'
        ];
    }
}
