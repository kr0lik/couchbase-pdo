<?php

declare(strict_types=1);

namespace kr0lik\CouchbasePdo\Factory;

use Couchbase\DecrementOptions as CouchbaseDecrementOptions;
use kr0lik\CouchbasePdo\Options\DecrementOptions;

class DecrementOptionsFactory
{
    public static function create(int $delta, ?DecrementOptions $options = null): CouchbaseDecrementOptions
    {
        $decrementOptions = new CouchbaseDecrementOptions();
        $decrementOptions->delta($delta);

        if (null !== $options?->getExpiry()) {
            $decrementOptions->expiry($options->getExpiry());
        }

        if (null !== $options?->getInitial()) {
            $decrementOptions->initial($options->getInitial());
        }

        if (null !== $options?->getTimeout()) {
            $decrementOptions->timeout($options->getTimeout());
        }

        return $decrementOptions;
    }
}
