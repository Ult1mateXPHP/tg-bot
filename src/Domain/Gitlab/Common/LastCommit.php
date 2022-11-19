<?php

declare(strict_types=1);

namespace App\Domain\Gitlab\Common;

class LastCommit
{
    public string $id;
    public string $message;
    public string $title;
    public string $timestamp;
    public string $url;
    public Author $author;
}