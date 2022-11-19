<?php

declare(strict_types=1);

namespace App\Domain\Gitlab\Push;

use App\Domain\Gitlab\Common\Commit;
use App\Domain\Gitlab\Common\Project;
use App\Domain\Gitlab\Common\Repository;

class PushEvent
{
    public string $object_kind;
    public string $event_name;
    public string $before;
    public string $after;
    public string $ref;
    public string $checkout_sha;
    public int $user_id;
    public string $user_name;
    public string $user_username;
    public string $user_email;
    public ?string $user_avatar;
    public int $project_id;
    public Project $project;
    public Repository $repository;

    /** @var array<Commit> */
    public array $commits;

    public int $total_commits_count;
}