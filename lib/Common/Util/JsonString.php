<?php

declare(strict_types=1);

namespace Lib\Common\Util;

use Stringable;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @template T
 */
interface JsonString extends Stringable
{
    /**
     * @psalm-return T|list<T>
     */
    public function deserialize(SerializerInterface $serializer): object|array;
}
