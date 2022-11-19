<?php

declare(strict_types=1);

namespace Lib\Common\Attribute;

use App\Infrastructure\Http\Resolver\ArgumentValue\QueryParamResolver;
use Attribute;

/**
 * Если добавить к аргументу контроллера
 * То {@see QueryParamResolver} зарезолвит переданный query-параметр
 */
#[Attribute(Attribute::TARGET_PARAMETER)]
class QueryParam
{
}
