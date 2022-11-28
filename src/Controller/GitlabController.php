<?php

declare(strict_types=1);

namespace App\Controller;

use App\Domain\Gitlab\MergeRequest\MergeRequest;
use App\Domain\Gitlab\Push\PushEvent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @deprecated
 * Удалить в будущем, оставил только для примера сериализации данных в существующий класс.
 * Например, 'Push Hook' => PushEvent::class
 */
class GitlabController extends AbstractController
{
    public const ROUTE = '/gitlab';

    public function __construct(
        private SerializerInterface $serializer,
        private DenormalizerInterface $denormalizer,
    )
    {
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

        $jsonContent = $request->getContent();
        $resultObject = $this->serializer->deserialize(data: $jsonContent, type: $method, format: 'json');

        return new JsonResponse(data: $resultObject, status: 200);
    }

    private function mergeRequest($resultObject): MergeRequest
    {
        return $this->denormalizer->denormalize($resultObject, MergeRequest::class);
    }
}
