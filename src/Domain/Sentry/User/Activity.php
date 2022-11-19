<?php

declare(strict_types=1);

namespace App\Domain\Sentry\User;

class Activity
{
    public bool $isBlock;
    public bool $isConfirmed;
    public string $lastIp;
    public string $lastLoginAt;
    public string $registeredAt;
}