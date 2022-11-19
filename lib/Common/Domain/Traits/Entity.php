<?php

declare(strict_types=1);

namespace Lib\Common\Domain\Traits;

use Lib\Common\Domain\Interfaces\EntityInterface;
use Symfony\Component\Uid\Uuid;
use Fp\Collections\HashContract;

/**
 * @see HashContract
 * @psalm-require-implements HashContract
 * @psalm-require-implements EntityInterface
 */
trait Entity
{
    protected Uuid $id;

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getIdAsString(): string
    {
        return $this->getId()->toRfc4122();
    }

    public function equals(mixed $that): bool
    {
        return $that instanceof EntityInterface
            && $this->getId()->equals($that->getId());
    }

    public function hashCode(): string
    {
        return $this->getIdAsString();
    }
}
