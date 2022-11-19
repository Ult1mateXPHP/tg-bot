<?php

declare(strict_types=1);

namespace Lib\Common\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class StrongPassword extends Constraint
{
    public string $message = 'This password sounds totally weak!';
}
