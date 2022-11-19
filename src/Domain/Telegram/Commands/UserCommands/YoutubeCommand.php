<?php

declare(strict_types=1);

namespace App\Domain\Telegram\Commands\UserCommands;

use Longman\TelegramBot\Commands\UserCommand;

use Longman\TelegramBot\Entities\InlineKeyboard;
use Longman\TelegramBot\Entities\Keyboard;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;
use Symfony\Component\Filesystem\Filesystem;

class YoutubeCommand extends UserCommand
{
    /**
     * @var string
     */
    protected $name = 'youtube';

    /**
     * @var string
     */
    protected $description = 'youtube command';

    /**
     * @var string
     */
    protected $usage = '/youtube';

    /**
     * @var string
     */
    protected $version = '1.0.0';

    protected $private_only = true;

    /**
     * Main command execution
     *
     * @return ServerResponse
     * @throws TelegramException
     */
    public function execute2(): ServerResponse
    {
        $msg = sprintf('This youtube downloader: %s', $this->checkYt());
        return $this->replyToUser($msg);
    }

    private function checkYt(): bool
    {
        $filesystem = new Filesystem();
        return $filesystem->exists('/usr/bin/yt-dlp');
    }

    public function execute(): ServerResponse
    {

        $keyboard = new InlineKeyboard([
            ['text' => 'Inline Query (current chat)', 'switch_inline_query_current_chat' => 'inline query...'],
            ['text' => 'Inline Query (other chat)', 'switch_inline_query' => 'inline query...'],
        ], [
            ['text' => 'Callback', 'callback_data' => 'выбранное качество видео'],
            ['text' => 'Open URL', 'url' => 'https://github.com/php-telegram-bot/example-bot'],
        ]);

        $keyboard
            ->setResizeKeyboard(true)
            ->setOneTimeKeyboard(true)
            ->setSelective(false);

        return $this->replyToUser('Выбери качество', [
            'reply_markup' => $keyboard,
        ]);
    }

    private function showButtons()
    {

    }

    private function downloadVideo()
    {

    }
}
