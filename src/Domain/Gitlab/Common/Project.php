<?php

declare(strict_types=1);

namespace App\Domain\Gitlab\Common;

class Project
{
    public int $id;
    public string $name;
    public string $description;
    public string $web_url;
    public ?string $avatar_url;
    public string $git_ssh_url;
    public string $git_http_url;
    public string $namespace;
    public int $visibility_level;
    public string $path_with_namespace;
    public string $default_branch;
    public string $homepage;
    public string $url;
    public string $ssh_url;
    public string $http_url;
}