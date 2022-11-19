<?php

declare(strict_types=1);

namespace Lib\Common\Traits;

trait JsonSerializableTrait
{
    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}
