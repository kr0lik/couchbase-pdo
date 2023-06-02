<?php

declare(strict_types=1);

namespace kr0lik\CouchbasePdo;

use Couchbase\Cluster;
use Couchbase\ClusterOptions;

final class CouchBaseConnection implements ConnectionInterface
{
    private string $url;
    private ClusterOptions $options;
    private ?Cluster $cluster = null;

    public function __construct(string $url, ClusterOptions $options)
    {
        $this->url = $url;
        $this->options = $options;
    }

    public function getCluster(): Cluster
    {
        if (null !== $this->cluster) {
            return $this->cluster;
        }

        $cluster = new Cluster($this->url, $this->options);

        $this->cluster = $cluster;

        return $cluster;
    }
}
