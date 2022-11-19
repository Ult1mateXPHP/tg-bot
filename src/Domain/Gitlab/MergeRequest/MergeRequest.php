<?php

declare(strict_types=1);

namespace App\Domain\Gitlab\MergeRequest;

use App\Domain\Gitlab\Common\Commit;
use App\Domain\Gitlab\Common\Project;
use App\Domain\Gitlab\Common\Repository;
use App\Domain\Gitlab\Common\User;

class MergeRequest
{
    public string $object_kind;
    public string $event_type;

    public User $user;
    public Project $project;
    public ObjectAttributes $object_attributes;

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

    public Repository $repository;

    /** @var array<Commit> */
    public array $commits;

    public int $total_commits_count;
}