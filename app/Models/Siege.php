<?php

namespace App\Models;

use App\Enums\SiegeStatus;
use App\Support\Siege\Result;
use App\Support\SiegeCaster;
use App\Support\SiegeConfiguration;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property SiegeConfiguration $configuration
 * @property Result $results
 * @property string|null $uuid
 * @property SiegeStatus $status
 * @property CarbonInterface $started_at
 */
class Siege extends Model
{
    use HasFactory;

    const COLUMN_STARTED_AT = 'started_at';
    const COLUMN_STATUS     = 'status';

    protected $casts = [
        self::COLUMN_STARTED_AT => 'datetime',
        self::COLUMN_STATUS     => SiegeStatus::class,
        'configuration'         => SiegeCaster::class,
        'results'               => SiegeCaster::class,
    ];

    public function isComplete(): bool
    {
        return $this->status == SiegeStatus::Complete;
    }
}
