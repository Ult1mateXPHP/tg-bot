<?php

declare(strict_types=1);

/**
 * Callback query command
 * This command handles all callback queries sent via inline keyboard buttons.
 * @see InlinekeyboardCommand.php
 */

namespace App\Domain\Telegram\Commands\SystemCommands;

use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Entities\ServerResponse;

class CallbackCommand extends SystemCommand
{
    /**
     * @var string
     */
    protected $name = 'callbackquery';

    /**
     * @var string
     */
    protected $description = 'Handle the callback query';

    /**
     * @var string
     */
    protected $version = '1.2.0';

    /**
     * Main command execution
     *
     * @return ServerResponse
     * @throws \Exception
     */
    public function execute(): ServerResponse
    {
        // Callback query data can be fetched and handled accordingly.
        $callback_query = $this->getCallbackQuery();
        $callback_data = $callback_query->getData();

        return $callback_query->answer([
            'text' => 'Content of the callback data: ' . $callback_data,
            'show_alert' => true,
            // Randomly show (or not) as an alert.
            'cache_time' => 5,
        ]);
    }
}
