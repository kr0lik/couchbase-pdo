<?php

declare(strict_types=1);

namespace kr0lik\CouchbasePdo\Bucket;

use Couchbase\Bucket;
use kr0lik\CouchbasePdo\CouchBaseConnection;

class BaseBucket implements CouchBaseBucketInterface
{
    private CouchBaseConnection $connection;
    private string $bucketName;
    private ?Bucket $bucket = null;

    public function __construct(CouchBaseConnection $connection, ?string $bucketName = null)
    {
        $this->connection = $connection;
        $this->bucketName = $bucketName;
    }

    public function getBucket(): Bucket
    {
        if (null !== $this->bucket) {
            return $this->bucket;
        }

        $bucketName = $this->transformOptions($this->bucketName);

        $cluster = $this->connection->getCluster();

        $bucket = $cluster->bucket($bucketName);

        $this->bucket = $bucket;

        return $bucket;
    }

    private function transformOptions(string $name): string
    {
        $parsedUrl = (array) parse_url($name);

        if (false === array_key_exists('query', $parsedUrl)
            || false === array_key_exists('path', $parsedUrl)) {
            return $name;
        }

        parse_str($parsedUrl['query'], $options);

        $mapping = [
            'query_timeout' => 'n1ql_timeout',
            'enable_mutation_tokens' => 'fetch_mutation_tokens',
        ];

        $mapping = array_flip($mapping);

        foreach ($options as $key => $option) {
            if (true === array_key_exists($key, $mapping)) {
                $options[$mapping[$key]] = $option;
                unset($options[$key]);
            }
        }

        return $parsedUrl['path'].'?'.http_build_query($options);
    }
}
