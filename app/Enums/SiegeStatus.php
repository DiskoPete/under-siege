<?php

namespace App\Enums;

enum SiegeStatus: int
{
    case Failed = 0;
    case Queued = 1;
    case InProgress = 2;
    case Complete = 3;
}
