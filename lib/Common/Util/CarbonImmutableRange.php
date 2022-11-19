<?php

declare(strict_types=1);

namespace Lib\Common\Util;

use Carbon\CarbonImmutable;
use App\Application\Exception\CarbonInvalidRangeException;

class CarbonImmutableRange
{
    /**
     * @throws CarbonInvalidRangeException
     */
    public function __construct(
        private CarbonImmutable $from,
        private CarbonImmutable $to,
    ) {
        CarbonInvalidRangeException::assertValidRange($from, $to);
    }

    public function getFrom(): CarbonImmutable
    {
        return $this->from;
    }

    public function getTo(): CarbonImmutable
    {
        return $this->to;
    }

}
