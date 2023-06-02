<?php

declare(strict_types=1);

namespace kr0lik\CouchbasePdo\Bucket;

use Couchbase\Bucket;

interface CouchBaseBucketInterface
{
    public function getBucket(): Bucket;
}
