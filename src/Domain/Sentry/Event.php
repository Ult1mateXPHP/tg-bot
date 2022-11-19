<?php

declare(strict_types=1);

namespace App\Domain\Sentry;

class Event
{

    public string $event_id;
    public string $level;
    public string $version;
    public string $type;

    /** array<string> */
    public array $fingerprint;

    public string $culprit;
    public string $logger;
    public string $platform;
    public int $timestamp;
    public float $received;
    public string $release;
    public string $environment;
    public Request $request;

    //public Contexts $contexts;

   //public Exception $exception;

    public array $tags;

    //public Sdk $sdk;
    public string $key_id;
    public int $project;
    public string $grouping_config;

//    public Metrics $_metrics;
//    public int $_ref;
//    public int $_ref_version;

    public array $hashes;
    public string $location;

    public Metadata $metadata;
    public string $nodestore_insert;

    public string $title;
    public string $id;

    /** Имеет смысл только для фронта (надо проверить!) */
    public Extra $extra;
}