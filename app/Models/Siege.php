<?php

namespace App\Models;

use App\Enums\SiegeStatus;
use App\Support\Siege\Result;
use App\Support\SiegeConfiguration;
use App\Support\SiegeCaster;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property SiegeConfiguration $configuration
 * @property Result $results
 * @property string|null $uuid
 * @property SiegeStatus $status
 */
class Siege extends Model
{
    use HasFactory;

    protected $casts = [
        'status'        => SiegeStatus::class,
        'configuration' => SiegeCaster::class,
        'results'       => SiegeCaster::class,
    ];
}
