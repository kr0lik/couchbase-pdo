<?php

declare(strict_types=1);

namespace kr0lik\CouchbasePdo\Enum;

final class QueryScanConsistency
{
    /**
     * Set scan consistency to not bounded
     */
    public const NOT_BOUNDED = 1;

    /**
     * Set scan consistency to not request plus
     */
    public const REQUEST_PLUS = 2;

    /**
     * Set scan consistency to statement plus
     */
    public const STATEMENT_PLUS = 3;
}
