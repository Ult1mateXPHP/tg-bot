<?php

declare(strict_types=1);

namespace Lib\Common\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @psalm-immutable
 */
#[\Attribute(\Attribute::TARGET_PROPERTY)]
class UniqueValue extends Constraint
{
    /**
     * @var class-string $entityClass
     */
    public string $entityClass;

    public function __construct(
        string $entityClass,
        public string $entityField,
        public bool $ignoreNull = true,
        public string $message = 'Entity with value {{value}} already exists!',
    ) {
        parent::__construct();

        /**
         * @var class-string $entityClass
         */
        $this->entityClass = $entityClass;
    }

    /**
     * {@inheritdoc}
     */
    public function getTargets(): array|string
    {
        return self::PROPERTY_CONSTRAINT;
    }
}
