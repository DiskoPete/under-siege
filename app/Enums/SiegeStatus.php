<?php

namespace App\Enums;

enum SiegeStatus: int
{
    case Failed = 0;
    case Queued = 1;
    case Preparing = 2;
    case InProgress = 3;
    case Complete = 4;

    public function getIconComponent(): string
    {
        return match($this){
            SiegeStatus::Queued => 'fas-clock',
            SiegeStatus::InProgress => 'fas-sync-alt',
            SiegeStatus::Preparing => 'fas-wrench',
            SiegeStatus::Failed => 'fas-exclamation-circle',
            default => 'fas-check'
        };
    }
}
