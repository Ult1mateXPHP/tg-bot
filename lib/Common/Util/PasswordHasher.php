<?php

declare(strict_types=1);

namespace Lib\Common\Util;

use RuntimeException;

class PasswordHasher
{
    public static function hash(string $password): string
    {
        $hash = password_hash($password, PASSWORD_BCRYPT);

        if (empty($hash)) {
            throw new RuntimeException('Unable to generate hash.');
        }

        return $hash;
    }

    public static function validate(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }
}
