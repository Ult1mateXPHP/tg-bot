<?php

declare(strict_types=1);

namespace Lib\Common\Traits;

use Faker\Factory;
use Faker\Generator;

trait InteractsWithFaker
{
    public static function getFaker(string $locale = 'ru_RU'): Generator
    {
        return Factory::create($locale);
    }
}
