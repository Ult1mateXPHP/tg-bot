<?php

declare(strict_types=1);

namespace App\Domain\Gitlab\Common;

class User extends Author
{
    public string $name;
    public string $email;
}