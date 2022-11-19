<?php

declare(strict_types=1);

namespace App\Cli;

use App\Service\TelegramService;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use function Lib\Functions\env;

#[AsCommand(
    name: 'util:set-hook',
    description: 'set hook',
    hidden: false
)]
class SetHookCli extends Command
{
    public function __construct(
        private readonly TelegramService $telegramService,
        private readonly LoggerInterface $logger
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $telegram = $this->telegramService->getTelegram();
        try {
            $url = env('BOT_HOOK_URL');
            $result = $telegram->setWebhook($url);

            $this->logger->info($result->getDescription());
            if ($result->isOk()) {
                $msg = sprintf('<info>Hook URL: %s</info>', $url);
                $output->writeln($msg);
                return Command::SUCCESS;
            }
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage());
            return Command::FAILURE;
        }

        return Command::FAILURE;
    }

}