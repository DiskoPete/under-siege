<?php

namespace App\Support;

use App\Support\Siege\Result;
use Illuminate\Support\Fluent;
use InvalidArgumentException;

class SiegeCaster implements \Illuminate\Contracts\Database\Eloquent\CastsAttributes
{
    /**
     * @inheritDoc
     */
    public function get($model, string $key, $value, array $attributes)
    {
        $data = $attributes[$key] ?? [];

        if (is_string($data)) {
            $data = json_decode($data, true);
        }

        return match ($key) {
            'configuration' => new SiegeConfiguration($data),
            'results' => $data ? new Result($data) : null
        };
    }

    /**
     * @inheritDoc
     */
    public function set($model, string $key, $value, array $attributes)
    {
        return [
            $key => $value instanceof Fluent ? $value->toJson() : null
        ];
    }
}
