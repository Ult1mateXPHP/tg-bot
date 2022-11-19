<?php

declare(strict_types=1);

namespace App\Controller;

use App\Domain\Gitlab\MergeRequest\MergeRequest;
use App\Domain\Gitlab\Push\PushEvent;
use App\Service\TelegramService;
use Longman\TelegramBot\Request as TG;
use Longman\TelegramBot\Telegram;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class GitlabController extends AbstractController
{
    public const ROUTE = '/gitlab';
    private TG $telegram;

    public function __construct(
        private SerializerInterface $serializer,
        private DenormalizerInterface $denormalizer,
        //private TelegramService $telegramService
    )
    {
        //$this->telegram = $this->telegramService->getRequest();
    }

    #[Route(path: self::ROUTE, name: 'gitlab', methods: ['POST'])]
    public function createAction(Request $request): Response
    {
        $header = $request->headers->get('x-gitlab-event');

        $method = match ($header) {
            'Push Hook' => PushEvent::class,
            'Tag Push Hook' => 'TAG',
            'Note Hook' => 'Comment',
            'Merge Request Hook' => MergeRequest::class,
            'Pipeline Hook' => 'Pipeline',
            'Deployment Hook' => 'Deployment',
            'Release Hook' => 'Release',
            default => 'Unknown Hook',
        };

        //$result = call_user_func($method, $request);

//        $jsonContent = file_get_contents(__DIR__ . '/../../httpclient/dataStructure/gitlab/push.json');
//        $jsonContent = file_get_contents(__DIR__ . '/../../httpclient/dataStructure/gitlab/merge_request.json');
        $jsonContent = $request->getContent();
        $resultObject = $this->serializer->deserialize(data: $jsonContent, type: $method, format: 'json');

        $data = [
            'text' => 'Test',
            'chat_id' => '103461321',
            'parse_mode' => 'HTML'
        ];

        //$result = $this->telegram::sendMessage($data);

        return new JsonResponse(data: $resultObject, status: 200);
    }

    private function mergeRequest($resultObject): MergeRequest
    {
        return $this->denormalizer->denormalize($resultObject, MergeRequest::class);
    }
}
