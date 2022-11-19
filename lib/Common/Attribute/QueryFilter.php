<?php

declare(strict_types=1);

namespace Lib\Common\Attribute;

use App\Infrastructure\Http\Resolver\ArgumentValue\QueryFilterResolver;
use Attribute;

/**
 * Если добавить к аргументу контроллера
 * то {@see QueryFilterResolver} зарезолвит переданные query-параметры
 * в экземпляр инпут-класса
 */
#[Attribute(Attribute::TARGET_PARAMETER)]
class QueryFilter
{
}
