<?php

declare(strict_types=1);

namespace App\Domain\Gitlab\Common;

class Author
{
    public int $id;
    public string $username;
    public string $avatar_url;

    /**
     * TODO: SEX
     * public string $sex;
     */
}