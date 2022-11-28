<?php

declare(strict_types=1);

namespace App\Domain\Telegram\Commands\UserCommands;

use Longman\TelegramBot\Commands\UserCommand;

use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;

class TestCommand extends UserCommand
{
    /**
     * @var string
     */
    protected $name = 'test';

    /**
     * @var string
     */
    protected $description = 'test command';

    /**
     * @var string
     */
    protected $usage = '/test';

    /**
     * @var string
     */
    protected $version = '1.0.0';

    protected $private_only = false;

    /**
     * Main command execution
     *
     * @return ServerResponse
     * @throws TelegramException
     */
    public function execute(): ServerResponse
    {
        return $this->replyToUser(
            'This is test' . PHP_EOL .
            'Type /help to see all commands!'
        );
    }
}
