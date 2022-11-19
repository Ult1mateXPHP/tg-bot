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
        $file = 'out.txt';
        $fs = new Filesystem();

        if ($fs->exists($file)) {
//            $formats = file_get_contents($file);
//            $output->writeln($formats);
            $lines = file($file, FILE_SKIP_EMPTY_LINES);
//            $ll = ArrayList::collect($lines);

            foreach ($lines as $line_num => $line) {
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

            $this->getFormats();
            return Command::SUCCESS;
        }

        return Command::FAILURE;
    }

    /**
     * List available formats
     */
    private function getFormats()
    {
//        $path = '/usr/bin/yt-dlp';
        $path = 'yt-dlp';
        $video = 'https://www.youtube.com/watch?v=sV6GPEF5Yxg';
        $output = [];
        exec(sprintf('%s -F %s', $path, $video), $output);
        var_dump($output);
        $allFormats = [];
        $enableFormats = [];
    }
}