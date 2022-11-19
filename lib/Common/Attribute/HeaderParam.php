<?php

declare(strict_types=1);

namespace Lib\Common\Attribute;

use App\Infrastructure\Http\Resolver\ArgumentValue\HeaderParamResolver;
use Attribute;

/**
 * Если добавить к аргументу контроллера
 * То {@see HeaderParamResolver} зарезолвит переданный header-параметр
 */
#[Attribute(Attribute::TARGET_PARAMETER)]
class HeaderParam
{
}
