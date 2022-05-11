<?php

namespace App\Support;

use Illuminate\Support\Fluent;

/**
 * @property string|null $target
 * @property int|null $duration
 * @property int|null $concurrent
 * @property \Illuminate\Support\Collection|string[]|null $urls
 * @property string[]|null $headers
 */
class SiegeConfiguration extends Fluent
{

}
