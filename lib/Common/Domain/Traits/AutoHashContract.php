<?php

declare(strict_types=1);

namespace Lib\Common\Domain\Traits;

use Carbon\CarbonInterface;
use Fp\Collections\HashComparator;
use Fp\Collections\HashContract;
use Symfony\Component\Uid\Uuid;

/**
 * @see HashContract
 * @psalm-require-implements HashContract
 */
trait AutoHashContract
{
    public function equals(mixed $that): bool
    {
        if (!$that instanceof self) {
            return false;
        }

        $vars = get_object_vars($this);

        foreach ($vars as $key => $value) {
            /**
             * @psalm-suppress InternalClass, InternalMethod
             */
            $isHashEquals = HashComparator::hashEquals(
                $this->normalize($this->{$key}),
                $this->normalize($that->{$key})
            );

            if (!$isHashEquals) {
                return false;
            }
        }

        return true;
    }

    public function hashCode(): string
    {
        return serialize($this);
    }

    private function normalize(mixed $subject): mixed
    {
        return match (true) {
            $subject instanceof CarbonInterface => $subject->toW3cString(),
            $subject instanceof Uuid => (string) $subject,
            default => $subject,
        };
    }
}
