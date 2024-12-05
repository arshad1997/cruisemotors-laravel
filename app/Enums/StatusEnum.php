<?php

namespace App\Enums;

enum StatusEnum: string
{
    case CREATED = 'CREATED';
    case RECEIVED = 'RECEIVED';
    case REVIEWED = 'REVIEWED';
    case REPLIED = 'REPLIED';
    case CONTACTED = 'CONTACTED';
    case RESOLVED = 'RESOLVED';
    case CLOSED = 'CLOSED';
    case CANCELLED = 'CANCELLED';
    case VERIFIED = 'VERIFIED';
    case PENDING = 'PENDING';
    case APPROVED = 'APPROVED';
    case REJECTED = 'REJECTED';

    public static function values(): array {
        return array_column(self::cases(), 'value');
    }
}
