<?php

declare(strict_types=1);

namespace App\Domain\Telegram\Commands\UserCommands;

use Longman\TelegramBot\Commands\UserCommand;

use Longman\TelegramBot\Entities\InlineKeyboard;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;
use Symfony\Component\Filesystem\Filesystem;

class YoutubeCommand extends UserCommand
{
    public const BINARY_PATH = '/usr/local/bin/yt-dlp';

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

    public function execute(): ServerResponse
    {
        $message = $this->getMessage();
        $link = $message->getText(true);
        if (!self::validateLink($link)) {
            return $this->replyToUser('ссылка на ролик не валидная');
        }

        if ($this->hasExistYt()) {
            $keyboard = $this->getFormats($link ?? '');

            return $this->replyToUser('Выбери качество:', [
                'reply_markup' => $keyboard,
            ]);
        }

        return $this->replyToUser('Не удалось получить данные о видеоролике');
    }

    private function hasExistYt(): bool
    {
        $filesystem = new Filesystem();
        return $filesystem->exists(self::BINARY_PATH);
    }

    private function getFormats(string $url): InlineKeyboard
    {
        $buttons = [];
        $matchedFormat = [];
        exec(sprintf('%s -F %s', self::BINARY_PATH, $url), $formats);
        foreach ($formats as $format) {
            if (preg_match(pattern: '/^(18|22|140|251)+/', subject: $format, matches: $matchedFormat)) {
                $button = match ((int)$matchedFormat[0]) {
                    18 => ['text' => 'mp4 360p', 'callback_data' => 18],
                    22 => ['text' => 'mp4 720p', 'callback_data' => 22],
                    140 => ['text' => '130k m4a', 'callback_data' => 140],
                    251 => ['text' => '140k opus', 'callback_data' => 251],
                    default => ['default button', 'callback_data' => 18]
                };
                $buttons[] = $button;
            }
        }
        $keyboard = new InlineKeyboard($buttons);

        return $keyboard
            ->setResizeKeyboard(true)
            ->setOneTimeKeyboard(true)
            ->setSelective(false);
    }

    public static function validateLink(?string $link): bool
    {
        if (empty($link)) {
            return false;
        }

        $pattern = '/(?:https?:\/\/)?(?:www\.)?youtu(?:\.be\/|be.com\/\S*(?:watch|embed)(?:(?:(?=\/[-a-zA-Z0-9_]{11,}(?!\S))\/)|(?:\S*v=|v\/)))([-a-zA-Z0-9_]{11,})/m';
        if (preg_match(pattern: $pattern, subject: $link)) {
            return true;
        }

        return false;
    }
}
