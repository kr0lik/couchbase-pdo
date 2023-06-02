<?php

declare(strict_types=1);

namespace kr0lik\CouchbasePdo;

use Couchbase\Cluster;

interface ConnectionInterface
{
    public function getCluster(): Cluster;
}
