<?php

declare(strict_types=1);

namespace App\Infrastructure\Logger;

use Monolog\DateTimeImmutable;
use Monolog\Processor\ProcessorInterface;

class LeadzvonProcessor implements ProcessorInterface
{
    public const ELASTIC_DATETIME_FORMAT = 'Y-m-d\TH:i:s.u\Z';

    protected array $record;

    public function __invoke(array $record): array
    {
        $this->record = $record;
        return $this->processRecord();
    }

    public function processRecord(): array
    {
        $this->withDateTime();
        $this->withMemoryUsage();
        $this->withRequestId();
        $this->dropEmptyFields();

        $this->dropUnwantedFields();

        return $this->record;
    }

    /**
     * Не записывать в лог пустые поля.
     */
    protected function dropEmptyFields(): void
    {
        foreach ($this->record['context'] as $key => $value) {
            if (empty($value)) {
                unset($this->record['context'][$key]);
            }
        }
    }

    /**
     * Бесполезные поля, нет смысла сохранять и отправлять их в Elasticsearch
     */
    protected function dropUnwantedFields(): void
    {
        unset(
            $this->record['context']['comment'],
            $this->record['context']['request']['security'],
        );
    }

    protected function withDateTime(): void
    {
        /** @var DateTimeImmutable $monologTime */
        $monologTime = $this->record['datetime'];
        $this->record['context']['@timestamp'] = $monologTime->format(self::ELASTIC_DATETIME_FORMAT);
    }

    protected function withMemoryUsage(): void
    {
        $this->record['context']['memory_usage'] = memory_get_usage(true);
    }

    /**
     * Логируются только ВХОДЯЩИЕ запросы от клиентов, не CLI и что-то внутреннее.
     * Добавляем request_id, который передаём нам nginx
     * Это позволяет связать запрос к серверу с сообщением в логах (Elasticsearch + Kibana)
     *
     * Необходимы настройки nginx /etc/nginx/fastcgi_params:
     * fastcgi_param  X_REQUEST_ID       $request_id;
     */
    protected function withRequestId(): void
    {
        if (array_key_exists('X_REQUEST_ID', $_SERVER) && $_SERVER['X_REQUEST_ID'] !== '') {
            $this->record['context']['requestId'] = $_SERVER['X_REQUEST_ID'] ?? '';
        }
    }

}
