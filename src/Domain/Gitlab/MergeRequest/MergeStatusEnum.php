<?php

declare(strict_types=1);

namespace App\Domain\Gitlab\MergeRequest;

/** ObjectAttributes->merge_status */
enum MergeStatusEnum: string
{
    case UNCHECKED = 'unchecked';
    case CANNOT_BE_MERGED = 'cannot_be_merged';
    case CAN_BE_MERGED = 'can_be_merged';
    case PREPARING = 'preparing';
}
