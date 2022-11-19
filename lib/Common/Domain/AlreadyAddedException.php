<?php

declare(strict_types=1);

namespace Lib\Common\Domain;

class AlreadyAddedException extends \DomainException
{
    public static function create(): AlreadyAddedException
    {
        return new self('Attempt to add already added entity to store.');
    }
}
