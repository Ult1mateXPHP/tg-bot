<?php

declare(strict_types=1);

namespace App\Cli;

use Fp\Collections\ArrayList;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\Filesystem\Filesystem;

use function Lib\Functions\env;

#[AsCommand(
    name: 'util:yt',
    description: 'youtube',
    hidden: false
)]
class YtCli extends Command
{
    public function __construct(
        private readonly LoggerInterface $logger
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $lines = [];
        $video = 'https://www.youtube.com/';
        $file = '/usr/local/bin/yt-dlp'; //'yt-dlp';
        $fs = new Filesystem();

        if ($fs->exists($file)) {
            exec(sprintf('%s -F %s', $file, $video), $lines);

            foreach ($lines as $line) {
                $matches = [];
                if (preg_match(pattern: '/^(18|22|140|251)+/', subject: $line, matches: $matches)) {
                    $format = (int)$matches[0];
                    $button = match ($format) {
                        18 => 'mp4 360p',
                        22 => 'mp4 720p',
                        140 => '130k m4a',
                        251 => '140k opus',
                        default => 'default button'
                    };
                    $output->writeln($button);
                }
            }

            return Command::SUCCESS;
        }

        return Command::FAILURE;
    }

    private static function validateLink(string $link): bool
    {
        $pattern = '/(?:https?:\/\/)?(?:www\.)?youtu(?:\.be\/|be.com\/\S*(?:watch|embed)(?:(?:(?=\/[-a-zA-Z0-9_]{11,}(?!\S))\/)|(?:\S*v=|v\/)))([-a-zA-Z0-9_]{11,})/m';
        if (preg_match(pattern: $pattern, subject: $link)) {
            return true;
        }

        return false;
    }
}