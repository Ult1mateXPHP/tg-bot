<?php

declare(strict_types=1);

namespace Lib\Common\Domain\Traits;

use Carbon\CarbonImmutable;

trait UpdatedAt
{
    protected ?CarbonImmutable $updatedAt = null;

    public function getUpdatedAt(): ?CarbonImmutable
    {
        return $this->updatedAt;
    }

    public function touch(): void
    {
        $this->setUpdatedAt(CarbonImmutable::now());
    }

    public function setUpdatedAt(CarbonImmutable $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
