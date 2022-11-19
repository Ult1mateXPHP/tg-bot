<?php

declare(strict_types=1);

namespace Lib\Common\Attribute;

use Attribute;

/**
 * Если добавить к методу контроллера/экшона,
 * то будет использоваться кэш Redis
 * Кешируются только GET запросы
 */
#[Attribute(Attribute::TARGET_METHOD | Attribute::TARGET_FUNCTION)]
class Cacheable
{
    public function __construct(

        /**
         * Время TTL в секундах
         */
        public int $expires = 30,

        /**
         * Подмешивать ли логин пользователя в кеш-ключ
         * Логин берём из JWT токена
         */
        public bool $mixUserToHash = false
    ) {
    }
}
