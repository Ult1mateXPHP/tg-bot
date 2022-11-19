<?php

declare(strict_types=1);

namespace App\Domain\Gitlab\MergeRequest;

/** ObjectAttributes->State */
enum StateEnum: string
{
    case OPENED = 'opened';
    case CLOSED = 'closed';
}
