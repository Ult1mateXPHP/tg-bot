<?php

declare(strict_types=1);

namespace Lib\Common\Domain\Traits;

trait SoftDelete
{
    protected bool $isDeleted = false;

    public function isDeleted(): bool
    {
        return $this->isDeleted;
    }

    public function delete(): void
    {
        $this->isDeleted = true;
    }

    public function rise(): void
    {
        $this->isDeleted = false;
    }

    public static function getFieldName(): string
    {
        return 'isDeleted';
    }
}
