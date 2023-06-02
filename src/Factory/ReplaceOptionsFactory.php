<?php

declare(strict_types=1);

namespace kr0lik\CouchbasePdo\Factory;

use Couchbase\ReplaceOptions as CouchbaseReplaceOptions;
use kr0lik\CouchbasePdo\Options\ReplaceOptions;

class ReplaceOptionsFactory
{
    public static function createFromReplaceOptions(ReplaceOptions $replaceOptions): CouchbaseReplaceOptions
    {
        $sdk3ReplaceOptions = new CouchbaseReplaceOptions();

        if (null !== $replaceOptions->getExpiry()) {
            $sdk3ReplaceOptions->expiry($replaceOptions->getExpiry());
        }

        return $sdk3ReplaceOptions;
    }
}
