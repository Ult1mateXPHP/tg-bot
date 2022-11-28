<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\TelegramService;
use Longman\TelegramBot\Telegram;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HookController extends AbstractController
{
    public const ROUTE = '/hook';
    private Telegram $telegram;

    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly TelegramService $telegramService
    )
    {
        $this->telegram = $this->telegramService->getTelegram();
    }

    #[Route(path: self::ROUTE, name: 'hook', methods: ['POST'])]
    public function hookAction(Request $request): Response
    {
        $content = (string)$request->getContent();
        $this->logger->info($content);
        try {
            $this->telegram->handle();
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage());
            return new Response(content: 'Ooops! Exception', status: 500);
        }
        return new Response(content: 'OK, test done!', status: 200);
    }

    /**
     * @todo доработать функционал отключения хука:
     * https://github.com/php-telegram-bot/example-bot/blob/master/unset.php
     */
    #[Route(path: '/unhook', name: 'test', methods: ['GET', 'POST'])]
    public function testAction(Request $request): Response
    {
        return new Response(content: 'OK, test done!', status: 200);
    }
}
