<?php

namespace App\Http\Requests;

use App\Support\SiegeConfiguration;
use Illuminate\Foundation\Http\FormRequest;

class CreateSiegeRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        return $this->merge([
            SiegeConfiguration::KEY_CRAWL => (bool)$this->crawl,
            SiegeConfiguration::KEY_INTENSITY => (float)$this->intensity
        ]);
    }

    public function rules(): array
    {
        return [
            SiegeConfiguration::KEY_CRAWL     => 'bool',
            'concurrent'                      => 'required|int|max:' . config('siege.max_concurrent_users'),
            SiegeConfiguration::KEY_INTENSITY => 'required|numeric',
            'duration'                        => 'required|int|max:' . config('siege.max_duration'),
            'target'                          => 'required|url',
            'headers'                         => 'array'
        ];
    }
}
