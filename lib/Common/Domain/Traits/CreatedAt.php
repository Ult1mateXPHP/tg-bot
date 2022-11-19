<?php

declare(strict_types=1);

namespace Lib\Common\Domain\Traits;

use Carbon\CarbonImmutable;

trait CreatedAt
{
    protected CarbonImmutable $createdAt;

    public function getCreatedAt(): CarbonImmutable
    {
        return $this->createdAt;
    }
}
