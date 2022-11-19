<?php

declare(strict_types=1);

namespace App\Cli;

use App\Service\TelegramClient;
use danog\MadelineProto\API;
use danog\MadelineProto\Logger;
use danog\MadelineProto\Settings;
use danog\MadelineProto\Settings\Database\Postgres;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'util:run',
    description: 'RUN CLIENT',
    aliases: ['util:run-client'],
    hidden: false
)]
class BotCli extends Command
{
    public function __construct(
        private TelegramClient $client
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $settings = new Settings;
        $settings->getLogger()->setLevel(Logger::LEVEL_ULTRA_VERBOSE);

        $MadelineProto = new API('session.madeline');
        $MadelineProto->updateSettings($settings);
        $MadelineProto->start();
        $MadelineProto->async(false);

        $channel = '-1001050100853';
        $range = range(4380, 4381);
        $updates = $MadelineProto->messages->getMessagesReactions(
            [
                $channel,
                $range
            ]
        );
        var_dump($updates["updates"][$n_post]["reactions"]["results"][$n_reaction]["reaction"]["emoticon"]);

//        $db  = (new Postgres)
//            ->setUri('tcp://db:5432')
//            ->setDatabase('hookbot')
//            ->setUsername('app')
//            ->setPassword('password');
//
////        $redis = (new Redis)
////            ->setUri('redis://127.0.0.1')
////            ->setPassword('pass');
////        $settings->setDb($redis);
//
//        $settings->setDb($db);

        // For users or bots
//        TelegramClient::startAndLoop('bot.madeline', $settings);

//        $this->telegramClient->updateSettings($settings);
//        $this->telegramClient->async(false);
//        $this->telegramClient->start();

        pcntl_signal(SIGTERM, SIG_DFL);
        pcntl_signal(SIGINT, SIG_DFL);
        return Command::FAILURE;
    }

}