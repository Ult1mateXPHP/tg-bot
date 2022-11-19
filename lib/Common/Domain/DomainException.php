<?php

declare(strict_types=1);

namespace Lib\Common\Domain;

use Symfony\Component\Uid\Uuid;

class DomainException extends \DomainException
{
    public static function format(string $message, ...$args): static
    {
        return new static(vsprintf($message, $args));
    }

    /**
     * @psalm-assert object $object
     * @throws self
     */
    public static function assertFound(string $objectName, string|Uuid $id, ?object $object): void
    {
        if (!$id instanceof Uuid) {
            $objectId = Uuid::fromString($id);
        } else {
            $objectId = $id;
        }

        if ($object === null) {
            throw self::format('%s %s not found', $objectName, $objectId);
        }
    }
}
