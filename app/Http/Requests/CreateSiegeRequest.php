<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateSiegeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'concurrent' => 'required|int|max:' . config('siege.max_concurrent_users'),
            'duration'   => 'required|int|max:' . config('siege.max_duration'),
            'target'     => 'required|url',
            'headers'    => 'array'
        ];
    }
}
