<?php

declare(strict_types=1);

namespace App\Domain\Gitlab\MergeRequest;

use App\Domain\Gitlab\Common\LastCommit;
use App\Domain\Gitlab\Common\SourceBranch;
use App\Domain\Gitlab\Common\TargetBranch;

class ObjectAttributes
{
    public ?string $assignee_id;
    public int $author_id;
    public string $created_at;
    public string $description;
    public ?int $head_pipeline_id;
    public int $id;
    public int $iid;
    public ?string $last_edited_at;
    public ?string $last_edited_by_id;
    public ?string $merge_commit_sha;
    public ?string $merge_error;
    public array $merge_params;

    public MergeStatusEnum $merge_status;

    public ?string $merge_user_id;
    public bool $merge_when_pipeline_succeeds;
    public ?string $milestone_id;
    public string $source_branch;
    public int $source_project_id;
    public int $state_id;
    public string $target_branch;
    public int $target_project_id;
    public int $time_estimate;
    public string $title;
    public string $updated_at;
    public ?string $updated_by_id;
    public string $url;
    public SourceBranch $source;
    public TargetBranch $target;
    public LastCommit $last_commit;

    public bool $work_in_progress;
    public int $total_time_spent;
    public int $time_change;
    public ?int $human_total_time_spent;
    public ?string $human_time_change;
    public ?int $human_time_estimate;
    public array $assignee_ids;

    public StateEnum $state;
    public ActionEnum $action;

    public string $oldrev;

}