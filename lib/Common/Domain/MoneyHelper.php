<?php

declare(strict_types=1);

namespace Lib\Common\Domain;

use Brick\Money\Currency;
use Brick\Money\Exception\UnknownCurrencyException;
use Brick\Money\Money;
use LogicException;

class MoneyHelper
{
    /**
     * @param mixed $pureMoney BigNumber|number|string
     * @param Currency $currency
     * @return int
     */
    public static function toDatabase(mixed $pureMoney, Currency $currency): int
    {
        try {
            return self::asInteger(Money::of($pureMoney, $currency->getCurrencyCode()));
        } catch (UnknownCurrencyException $e) {
            throw new LogicException(previous: $e);
        }
    }

    public static function asInteger(Money $money): int
    {
        return $money->getMinorAmount()->toInt();
    }

    public static function asFloat(Money $money): float
    {
        return $money->getAmount()->toFloat();
    }

    /**
     * @param int $price
     * @param Currency $currency
     * @return Money
     */
    public static function fromDatabase(int $price, Currency $currency): Money
    {
        try {
            return Money::ofMinor($price, $currency->getCurrencyCode());
        } catch (UnknownCurrencyException $e) {
            throw new LogicException(previous: $e);
        }
    }
}
