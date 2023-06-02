<?php

declare(strict_types=1);

namespace kr0lik\CouchbasePdo\Factory;

use Couchbase\UpsertOptions as CouchbaseUpsertOptions;
use kr0lik\CouchbasePdo\Options\UpsertOptions;

class UpsertOptionsFactory
{
    public static function createFromUpsertOptions(UpsertOptions $upsertOptions): CouchbaseUpsertOptions
    {
        $sdk3UpsertOptions = new CouchbaseUpsertOptions();

        if (null !== $upsertOptions->getExpiry()) {
            $sdk3UpsertOptions->expiry($upsertOptions->getExpiry());
        }

        return $sdk3UpsertOptions;
    }
}
