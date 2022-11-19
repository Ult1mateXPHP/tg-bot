<?php

declare(strict_types=1);

namespace App\Domain\Gitlab\Common;

class Repository
{
    public string $name;
    public string $url;
    public string $description;
    public string $homepage;
    public string $git_http_url;
    public string $git_ssh_url;
    public int $visibility_level;
}