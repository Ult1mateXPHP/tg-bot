<?php

declare(strict_types=1);

namespace App\Domain\Sentry\User;

/** Тип специфичный для leadzvon */
class User
{
    public string $id;
    public string $email;
    public string $ip_address;
    public string $name;
    public Data $data;
}