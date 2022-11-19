<?php

declare(strict_types=1);

namespace App\Domain\Gitlab\MergeRequest;

/** ObjectAttributes->Action */
enum ActionEnum: string
{
    case OPEN = 'open';
    case CLOSE = 'close';
    case REOPEN = 'reopen';
    case UPDATE = 'update';
    case APPROVED = 'approved';
    case UNAPPROVED = 'unapproved';
    case MERGE = 'merge';
}
