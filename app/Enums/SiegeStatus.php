<?php

namespace App\Enums;

enum SiegeStatus: int
{
    case Failed = 0;
    case Queued = 1;
    case InProgress = 2;
    case Complete = 3;

    public function getIconComponent(): string
    {
        return match($this){
            SiegeStatus::Queued => 'fas-clock',
            SiegeStatus::InProgress => 'fas-sync-alt',
            SiegeStatus::Failed => 'fas-exclamation-circle',
            default => 'fas-check'
        };
    }
}
