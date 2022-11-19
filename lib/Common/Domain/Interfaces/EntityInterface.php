<?php

declare(strict_types=1);

namespace Lib\Common\Domain\Interfaces;

use Symfony\Component\Uid\Uuid;

interface EntityInterface
{
    public function getId(): Uuid;
}
