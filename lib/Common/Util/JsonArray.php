<?php

declare(strict_types=1);

namespace Lib\Common\Util;

use Symfony\Component\Serializer\SerializerInterface;

/**
 * @psalm-template T of object
 * @implements JsonString<T>
 */
class JsonArray implements JsonString
{
    protected string $json;

    /**
     * @var class-string<T>
     */
    protected string $className;

    /**
     * @param class-string<T> $className
     */
    public function __construct(string $json, string $className)
    {
        $this->json = $json;
        $this->className = $className;
    }

    /**
     * @return list<T>
     */
    public function deserialize(SerializerInterface $serializer): array
    {
        /**
         * @var list<T>
         */
        return $serializer->deserialize(
            $this->json,
            $this->className . '[]',
            'json'
        );
    }

    public function __toString(): string
    {
        return $this->json;
    }
}
