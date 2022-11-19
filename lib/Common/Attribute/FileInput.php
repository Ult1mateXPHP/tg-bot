<?php

declare(strict_types=1);

namespace Lib\Common\Attribute;

use App\Infrastructure\Http\Resolver\ArgumentValue\FileInputResolver;
use Attribute;

/**
 * Если добавить к аргументу контроллера
 * То {@see FileInputResolver} зарезолвит переданный файл/файлы в инпут
 */
#[Attribute(Attribute::TARGET_PARAMETER)]
class FileInput
{
}
