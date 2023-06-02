<?php

declare(strict_types=1);

namespace kr0lik\CouchbasePdo\Factory;

use Couchbase\IncrementOptions as CouchbaseIncrementOptions;
use kr0lik\CouchbasePdo\Options\IncrementOptions;

class IncrementOptionsFactory
{
    public static function create(int $delta, ?IncrementOptions $options = null): CouchbaseIncrementOptions
    {
        $incrementOptions = new CouchbaseIncrementOptions();
        $incrementOptions->delta($delta);

        if (null !== $options?->getExpiry()) {
            $incrementOptions->expiry($options->getExpiry());
        }

        if (null !== $options?->getInitial()) {
            $incrementOptions->initial($options->getInitial());
        }

        if (null !== $options?->getTimeout()) {
            $incrementOptions->timeout($options->getTimeout());
        }

        return $incrementOptions;
    }
}
