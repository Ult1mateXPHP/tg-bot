<?php

declare(strict_types=1);

namespace Lib\Common\Attribute;

use Attribute;

/**
 * Если добавить к методу контроллера,
 * То он обернётся в транзакцию
 */
#[Attribute(Attribute::TARGET_METHOD | Attribute::TARGET_FUNCTION)]
class Transactional
{
}
