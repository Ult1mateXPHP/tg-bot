<?php

declare(strict_types=1);

namespace Lib\Functions;

use BackedEnum;
use Fp\Functional\Either\Right;
use Fp\Functional\Option\Option;
use Lib\Common\Exception\UndefinedEnvironmentParameter;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Uid\UuidV4;

use function Fp\Json\jsonDecode;
use function JmesPath\search;
use function Symfony\Component\String\s;

function identify(): UuidV4
{
    return UuidV4::v4();
}

/**
 * @param string $name
 * @return string
 * @throws UndefinedEnvironmentParameter
 */
function env(string $name): string
{
    $value = $_ENV[$name] ?? getenv($name);

    if (empty($value)) {
        throw new UndefinedEnvironmentParameter();
    }

    return $value;
}

/**
 * @psalm-template TKey
 * @psalm-template TValue
 * @param array<TKey, TValue> $a
 * @return TValue
 */
function getRandomElement(array $a): mixed
{
    $randKey = array_rand($a);

    return $a[$randKey];
}

/**
 * Get public service alias
 */
function publicAlias(string $serviceId): string
{
    return 'public.' . $serviceId;
}

function optionalString(array $items): ?string
{
    if (empty($items)) {
        return null;
    }

    return implode(',', $items);
}

/** 
 * @psalm-param array<BackedEnum> $items 
 */
function optionalStringOfEnums(array $items): ?string
{
    if (empty($items)) {
        return null;
    }

    return implode(',', array_map(static fn($enum) => $enum->value, $items));
}

function toCamel(string $string): string
{
    return s($string)->lower()->camel()->toString();
}

function nullUuid(): Uuid
{
    return new Uuid('00000000-0000-0000-0000-000000000000');
}

/**
 * Search by JsonPath expression
 * Returns None if there is no data by given expression
 *
 * REPL:
 * >>> jsonSearch('a[0].b', ['a' => [['b' => true]]]);
 * => true
 * >>> jsonSearch('a[0].b', '{"a": [{"b": true}]}');
 * => true
 *
 * @psalm-param string $expr json path expression
 * @psalm-param array|string $data json-string or decoded into associative array json
 *
 * @psalm-return Option<array|scalar>
 *
 * @see jmespath
 */
function jsonSearch(string $expr, array|string $data): Option
{
    $decodedEither = is_string($data)
        ? jsonDecode($data)
        : Right::of($data);

    return Option::do(function () use ($decodedEither, $expr) {
        $decoded = yield $decodedEither->toOption();

        /** @psalm-var array|scalar|null $nullableResult */
        $nullableResult = search($expr, $decoded);

        return yield Option::fromNullable($nullableResult);
    });
}

function replaceArrayKey(array $array, string $oldKey, string $newKey): array
{
    $array[$newKey] = $array[$oldKey];
    unset($array[$oldKey]);
    return $array;
}
