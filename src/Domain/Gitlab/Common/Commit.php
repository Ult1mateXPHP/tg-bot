<?php

declare(strict_types=1);

namespace App\Domain\Gitlab\Common;

class Commit extends LastCommit
{
    /**
     * @var array<string>
     */
    public array $added;

    /**
     * @var array<string>
     */
    public array $modified;

    /**
     * @var array<string>
     */
    public array $removed;
}