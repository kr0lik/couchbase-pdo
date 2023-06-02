<?php

declare(strict_types=1);

namespace kr0lik\CouchbasePdo;

use kr0lik\CouchbasePdo\Options\GetOptions;
use kr0lik\CouchbasePdo\Options\InsertOptions;
use kr0lik\CouchbasePdo\Options\QueryOptions;
use kr0lik\CouchbasePdo\Options\RemoveOptions;
use kr0lik\CouchbasePdo\Options\ReplaceOptions;
use kr0lik\CouchbasePdo\Options\UpsertOptions;
use kr0lik\CouchbasePdo\Result\CommonResult;
use kr0lik\CouchbasePdo\Result\DocumentResult;
use kr0lik\CouchbasePdo\Result\QueryResult;

interface ClientInterface
{
    public function insert(string $id, mixed $insertDocument, ?InsertOptions $options = null): CommonResult;

    public function upsert(string $id, mixed $upsertDocument, ?UpsertOptions $options = null): CommonResult;

    public function queueRemove(string $id): ?string;

    public function touch(string $id, int $expiry): CommonResult;

    public function getName(): string;

    public function query(string $query, ?QueryOptions $options = null): QueryResult;

    public function get(string $id, ?GetOptions $options = null): DocumentResult;

    /**
     * @param string[] $ids
     *
     * @return DocumentResult[]
     */
    public function getAll(array $ids, ?GetOptions $options = null): array;

    /**
     * @param string[] $ids
     *
     * @return DocumentResult[]
     */
    public function batchRemove(array $ids, ?RemoveOptions $options = null): array;

    public function remove(string $id, ?RemoveOptions $options = null): CommonResult;

    public function replace(string $id, mixed $replaceDocument, ?ReplaceOptions $options = null): CommonResult;
}
