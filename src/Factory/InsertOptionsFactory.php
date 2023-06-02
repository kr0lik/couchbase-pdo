<?php

declare(strict_types=1);

namespace kr0lik\CouchbasePdo\Factory;

use Couchbase\InsertOptions as CouchbaseInsertOptions;
use kr0lik\CouchbasePdo\Options\InsertOptions;

class InsertOptionsFactory
{
    public static function createFromInsertOptions(InsertOptions $insertOptions): CouchbaseInsertOptions
    {
        $sdk3InsertOptions = new CouchbaseInsertOptions();

        if (null !== $insertOptions->getExpiry()) {
            $sdk3InsertOptions->expiry($insertOptions->getExpiry());
        }

        return $sdk3InsertOptions;
    }
}
