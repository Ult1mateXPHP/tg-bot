<?php

declare(strict_types=1);

namespace App\Domain\Sentry;

class MainEvent
{
    public string $id;
    public string $project;
    public string $project_name;
    public string $project_slug;
    public string $logger;
    public string $level;
    public string $culprit;
    public string $message;
    public string $url;
    public string $triggering_rules;
    public Event $event;
}