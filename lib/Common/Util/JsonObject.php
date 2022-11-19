<?php

declare(strict_types=1);

namespace Lib\Common\Util;

use Symfony\Component\Serializer\SerializerInterface;

/**
 * @psalm-template T of object
 * @implements JsonString<T>
 */
class JsonObject implements JsonString
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
     * @return T
     */
    public function deserialize(SerializerInterface $serializer): object
    {
        /**
         * @var T
         */
        return $serializer->deserialize(
            $this->json,
            $this->className,
            'json'
        );
    }

    public function __toString(): string
    {
        return $this->json;
    }
}
