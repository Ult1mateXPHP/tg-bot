<?php

declare(strict_types=1);

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SentryController extends AbstractController
{
    public const ROUTE = '/sentry';

    public function __construct(private LoggerInterface $sentryLogger)
    {
    }

    #[Route(path: self::ROUTE, name: 'sentry', methods: ['POST'])]
    public function createAction(Request $request): Response
    {
        $content = $request->toArray();
        $this->sentryLogger->info('input_message', $content);
        return new Response(content: 'OK!', status: 201);
    }
}
