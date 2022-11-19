<?php

declare(strict_types=1);

namespace Lib\Common\Validator\Constraints;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniqueValueValidator extends ConstraintValidator
{
    public function __construct(private ManagerRegistry $registry)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function validate(mixed $value, Constraint $constraint): void
    {
        assert($constraint instanceof UniqueValue);

        $entityRepository = $this->registry->getRepository($constraint->entityClass);

        $searchResults = $entityRepository->findBy(
            [
                $constraint->entityField => $value
            ]
        );

        if ($constraint->ignoreNull && null === $value) {
            return;
        }

        if (count($searchResults) > 0) {
            $this->context->buildViolation($constraint->message, ['{{value}}' => $value])
                ->addViolation();
        }
    }
}
