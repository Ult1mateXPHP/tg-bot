<?php

declare(strict_types=1);

/**
 * Gets executed when any type of message is sent.
 *
 * In this service-message-related context, we can handle any incoming service-messages.
 */

namespace App\Domain\Telegram\Commands\ServiceMessages;

use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Request;

class GenericmessageCommand extends SystemCommand
{
    public const MESSAGES = [
        'Слыш, может без войсов?',
        'Тут принято уважать время других и не слать войсы',
        'Давай без голосовых, а!?'
    ];


    /**
     * @var string
     */
    protected $name = 'genericmessage';

    /**
     * @var string
     */
    protected $description = 'Handle generic message';

    /**
     * @var string
     */
    protected $version = '1.0.0';

    /**
     * Catch and handle any service messages
     *
     * @return ServerResponse
     * @throws TelegramException
     */
    public function execute(): ServerResponse
    {
        $message = $this->getMessage();
        $type = $message->getType();

        if ($type === 'voice' || $type === 'video_note') {
            $replies = self::MESSAGES;
            shuffle($replies);

            return $this->replyToChat($replies[0], [
                    'reply_to_message_id' => $message->getMessageId()
            ]);

        }

        return Request::emptyResponse();
    }
}
