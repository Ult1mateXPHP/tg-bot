<?php

declare(strict_types=1);

namespace Lib\Common\Domain\Interfaces;

interface SoftDeleteInterface
{
    public function isDeleted(): bool;
    public function delete(): void;
    public function rise(): void;
    public static function getFieldName(): string;
}
