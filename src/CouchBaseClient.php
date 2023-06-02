<?php

declare(strict_types=1);

namespace kr0lik\CouchbasePdo;

use Couchbase\BaseException;
use Couchbase\CasMismatchException;
use Couchbase\DmlFailureException;
use Couchbase\DocumentNotFoundException;
use Couchbase\KeyExistsException as CouchbaseKeyExistsException;
use Couchbase\TimeoutException as CouchbaseTimeoutException;
use kr0lik\CouchbasePdo\Bucket\BaseBucket;
use kr0lik\CouchbasePdo\Datastructures\CouchbaseQueue;
use kr0lik\CouchbasePdo\Exception\CommonCouchbaseException;
use kr0lik\CouchbasePdo\Exception\KeyExistsException;
use kr0lik\CouchbasePdo\Exception\NotFoundException;
use kr0lik\CouchbasePdo\Exception\TimeoutException;
use kr0lik\CouchbasePdo\Factory\DecrementOptionsFactory;
use kr0lik\CouchbasePdo\Factory\IncrementOptionsFactory;
use kr0lik\CouchbasePdo\Factory\InsertOptionsFactory;
use kr0lik\CouchbasePdo\Factory\QueryOptionsFactory;
use kr0lik\CouchbasePdo\Factory\ReplaceOptionsFactory;
use kr0lik\CouchbasePdo\Factory\UpsertOptionsFactory;
use kr0lik\CouchbasePdo\Options\DecrementOptions;
use kr0lik\CouchbasePdo\Options\GetOptions;
use kr0lik\CouchbasePdo\Options\IncrementOptions;
use kr0lik\CouchbasePdo\Options\InsertOptions;
use kr0lik\CouchbasePdo\Options\QueryOptions;
use kr0lik\CouchbasePdo\Options\RemoveOptions;
use kr0lik\CouchbasePdo\Options\ReplaceOptions;
use kr0lik\CouchbasePdo\Options\UpsertOptions;
use kr0lik\CouchbasePdo\Result\CommonResult;
use kr0lik\CouchbasePdo\Result\DocumentResult;
use kr0lik\CouchbasePdo\Result\QueryMetaData;
use kr0lik\CouchbasePdo\Result\QueryResult;

class CouchBaseClient implements ClientInterface
{
    private BaseBucket $bucket;

    public function __construct(BaseBucket $bucket)
    {
        $this->bucket = $bucket;
    }

    /**
     * @throws CommonCouchbaseException
     * @throws KeyExistsException
     */
    public function insert(string $id, mixed $insertDocument, ?InsertOptions $options = null): CommonResult
    {
        $insertOptions = null;

        if (null !== $options) {
            $insertOptions = InsertOptionsFactory::createFromInsertOptions($options);
        }

        try {
            $mutationResult = $this->bucket
                ->getBucket()
                ->defaultCollection()
                ->insert($id, $insertDocument, $insertOptions)
            ;
        } catch (CouchbaseKeyExistsException $e) {
            throw new KeyExistsException($e->getMessage(), $e->getCode(), $e);
        } catch (BaseException $e) {
            throw new CommonCouchbaseException($e->getMessage(), $e->getCode(), $e);
        }

        return new CommonResult($mutationResult->cas());
    }

    /**
     * @throws CommonCouchbaseException
     */
    public function upsert(string $id, mixed $upsertDocument, ?UpsertOptions $options = null): CommonResult
    {
        $upsertOptions = null;

        if (null !== $options) {
            $upsertOptions = UpsertOptionsFactory::createFromUpsertOptions($options);
        }

        try {
            $mutationResult = $this->bucket->getBucket()->defaultCollection()->upsert($id, $upsertDocument, $upsertOptions);
        } catch (BaseException $e) {
            throw new CommonCouchbaseException($e->getMessage(), $e->getCode(), $e);
        }

        return new CommonResult($mutationResult->cas());
    }

    /**
     * @throws CommonCouchbaseException
     */
    public function queueRemove(string $id): ?string
    {
        try {
            $collection = $this->bucket->getBucket()->defaultCollection();
        } catch (BaseException $e) {
            throw new CommonCouchbaseException($e->getMessage(), $e->getCode(), $e);
        }

        $couchbaseQueue = new CouchbaseQueue($id, $collection);

        return $couchbaseQueue->pop();
    }

    /**
     * @throws CommonCouchbaseException
     */
    public function touch(string $id, int $expiry): CommonResult
    {
        try {
            $mutationResult = $this->bucket->getBucket()->defaultCollection()->touch($id, $expiry);
        } catch (BaseException $e) {
            throw new CommonCouchbaseException($e->getMessage(), $e->getCode(), $e);
        }

        return new CommonResult($mutationResult->cas());
    }

    public function getName(): string
    {
        return $this->bucket->getBucket()->name();
    }

    /**
     * @throws CommonCouchbaseException
     * @throws TimeoutException
     */
    public function query(string $query, ?QueryOptions $options = null): QueryResult
    {
        $queryOptions = null;

        if (null !== $options) {
            $queryOptions = QueryOptionsFactory::createFromQueryOptions($options);
        }

        try {
            $result = $this->bucket->getBucket()->defaultScope()->query($query, $queryOptions);
        } catch (CouchbaseTimeoutException $e) {
            throw new TimeoutException($e->getMessage(), $e->getCode(), $e);
        } catch (DmlFailureException|CasMismatchException $e) {
            $meta = (new QueryMetaData())->setStatus('error')->setErrors([$e->getMessage()]);

            return (new QueryResult())->setMeta($meta);
        } catch (BaseException $e) {
            throw new CommonCouchbaseException($e->getMessage(), $e->getCode(), $e);
        }

        $meta = $result->metaData();

        if (null !== $meta) {
            $meta = (new QueryMetaData())
                ->setStatus($meta->status())
                ->setRequestId($meta->requestId())
                ->setClientContextId($meta->clientContextId())
                ->setSignature($meta->signature())
                ->setWarnings($meta->warnings())
                ->setErrors($meta->errors())
                ->setMetrics($meta->metrics())
            ;
        }

        return (new QueryResult())->setRows($result->rows())->setMeta($meta);
    }

    /**
     * @throws CommonCouchbaseException
     * @throws NotFoundException
     */
    public function get(string $id, ?GetOptions $options = null): DocumentResult
    {
        $getOptions = null;

        try {
            $document = $this->bucket->getBucket()->defaultCollection()->get($id, $getOptions);
        } catch (DocumentNotFoundException $e) {
            throw new NotFoundException($e->getMessage(), $e->getCode(), $e);
        } catch (BaseException $e) {
            throw new CommonCouchbaseException($e->getMessage(), $e->getCode(), $e);
        }

        return (new DocumentResult())->setCas($document->cas())->setContent($document->content());
    }

    /**
     * @return DocumentResult[]
     */
    public function getAll(array $ids, ?GetOptions $options = null): array
    {
        $documents = [];

        foreach ($ids as $id) {
            $exception = null;

            try {
                $document = $this->bucket->getBucket()->defaultCollection()->get($id);
            } catch (DocumentNotFoundException $e) {
                $exception = new NotFoundException($e->getMessage(), $e->getCode(), $e);
            } catch (BaseException $e) {
                $exception = new CommonCouchbaseException($e->getMessage(), $e->getCode(), $e);
            }

            $documents[$id] = (new DocumentResult())
                ->setCas(isset($document) ? $document->cas() : null)
                ->setContent(isset($document) ? $document->content() : null)
                ->setError($exception)
            ;
        }

        return $documents;
    }

    /**
     * @return DocumentResult[]
     */
    public function batchRemove(array $ids, ?RemoveOptions $options = null): array
    {
        $documents = [];

        foreach ($ids as $id) {
            $exception = null;

            try {
                $document = $this->bucket->getBucket()->defaultCollection()->remove($id);
            } catch (DocumentNotFoundException $e) {
                $exception = new NotFoundException($e->getMessage(), $e->getCode(), $e);
            } catch (BaseException $e) {
                $exception = new CommonCouchbaseException($e->getMessage(), $e->getCode(), $e);
            }

            $documents[$id] = (new DocumentResult())
                ->setCas(isset($document) ? $document->cas() : null)
                ->setError($exception)
            ;
        }

        return $documents;
    }

    /**
     * @throws CommonCouchbaseException
     * @throws NotFoundException
     */
    public function remove(string $id, ?RemoveOptions $options = null): CommonResult
    {
        try {
            $mutationResult = $this->bucket->getBucket()->defaultCollection()->remove($id);
        } catch (DocumentNotFoundException $e) {
            throw new NotFoundException($e->getMessage(), $e->getCode(), $e);
        } catch (BaseException $e) {
            throw new CommonCouchbaseException($e->getMessage(), $e->getCode(), $e);
        }

        return new CommonResult($mutationResult->cas());
    }

    /**
     * @throws CommonCouchbaseException
     * @throws NotFoundException
     */
    public function replace(string $id, mixed $replaceDocument, ?ReplaceOptions $options = null): CommonResult
    {
        $replaceOptions = null;

        if ($options instanceof ReplaceOptions) {
            $replaceOptions = ReplaceOptionsFactory::createFromReplaceOptions($options);
        }

        try {
            $mutationResult = $this->bucket->getBucket()->defaultCollection()->replace($id, $replaceDocument, $replaceOptions);
        } catch (DocumentNotFoundException $e) {
            throw new NotFoundException($e->getMessage(), $e->getCode(), $e);
        } catch (BaseException $e) {
            throw new CommonCouchbaseException($e->getMessage(), $e->getCode(), $e);
        }

        return new CommonResult($mutationResult->cas());
    }

    /**
     * @throws CommonCouchbaseException
     */
    public function increment(string $id, int $delta, ?IncrementOptions $options = null): CommonResult
    {
        $incrementOptions = IncrementOptionsFactory::create($delta, $options);

        try {
            $mutationResult = $this->bucket->getBucket()->defaultCollection()->binary()->increment($id, $incrementOptions);
        } catch (BaseException $e) {
            throw new CommonCouchbaseException($e->getMessage(), $e->getCode(), $e);
        }

        return new CommonResult($mutationResult->cas());
    }

    /**
     * @throws CommonCouchbaseException
     */
    public function decrement(string $id, int $delta, ?DecrementOptions $options = null): CommonResult
    {
        $decrementOptions = DecrementOptionsFactory::create($delta, $options);

        try {
            $mutationResult = $this->bucket->getBucket()->defaultCollection()->binary()->decrement($id, $decrementOptions);
        } catch (BaseException $e) {
            throw new CommonCouchbaseException($e->getMessage(), $e->getCode(), $e);
        }

        return new CommonResult($mutationResult->cas());
    }
}
