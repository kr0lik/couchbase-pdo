<?php

declare(strict_types=1);

namespace kr0lik\CouchbasePdo\Factory;

use Couchbase\QueryOptions as CouchbaseQueryOptions;
use kr0lik\CouchbasePdo\Options\QueryOptions;

class QueryOptionsFactory
{
    public static function createFromQueryOptions(QueryOptions $queryOptions): CouchbaseQueryOptions
    {
        $sdk3QueryOptions = new CouchbaseQueryOptions();

        if (null !== $queryOptions->getScanConsistency()) {
            $sdk3QueryOptions->scanConsistency($queryOptions->getScanConsistency());
        }

        return $sdk3QueryOptions;
    }
}
