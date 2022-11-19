<?php

declare(strict_types=1);

namespace Lib\Common\Attribute;

use App\Infrastructure\Http\Resolver\ArgumentValue\PathParamResolver;
use Attribute;

/**
 * Если добавить к аргументу контроллера
 * То {@see PathParamResolver} зарезолвит переданный path-параметр
 */
#[Attribute(Attribute::TARGET_PARAMETER)]
class PathParam
{
}
