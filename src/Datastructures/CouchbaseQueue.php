<?php

declare(strict_types=1);

namespace kr0lik\CouchbasePdo\Datastructures;

use ArrayIterator;
use Couchbase\Collection;
use Couchbase\DocumentNotFoundException;
use Couchbase\LookupCountSpec;
use Couchbase\LookupGetSpec;
use Couchbase\MutateArrayPrependSpec;
use Couchbase\MutateRemoveSpec;
use Couchbase\StoreSemantics;
use Countable;
use EmptyIterator;
use IteratorAggregate;
use kr0lik\CouchbasePdo\Datastructures\Options\CouchbaseQueue as CouchbaseQueueOptions;
use Traversable;

class CouchbaseQueue implements Countable, IteratorAggregate
{
    private string $id;
    private Collection $collection;
    private CouchbaseQueueOptions $options;

    public function __construct(string $id, Collection $collection, ?CouchbaseQueueOptions $options = null)
    {
        $this->id = $id;
        $this->collection = $collection;
        $this->options = $options ?? new CouchbaseQueueOptions(null, null, null, null);
    }

    /**
     * @return int number of elements in the list
     */
    public function count(): int
    {
        try {
            $result = $this->collection->lookupIn(
                $this->id,
                [new LookupCountSpec('')],
                $this->options->lookupInOptions()
            );

            return (int) $result->content(0);
        } catch (DocumentNotFoundException $ex) {
            return 0;
        }
    }

    public function empty(): bool
    {
        return 0 === $this->count();
    }

    public function pop(): ?string
    {
        try {
            $result = $this->collection->lookupIn(
                $this->id,
                [new LookupGetSpec('[-1]', false)],
                $this->options->lookupInOptions()
            );
            $value = $result->content(0);
            $options = clone $this->options->mutateInOptions();
            $options->cas($result->cas());
            $this->collection->mutateIn(
                $this->id,
                [new MutateRemoveSpec('[-1]', false)],
                $options
            );

            return (string) $value;
        } catch (DocumentNotFoundException $ex) {
            return null;
        }
    }

    public function push(mixed $value): void
    {
        $options = clone $this->options->mutateInOptions();
        $options->storeSemantics(StoreSemantics::UPSERT);
        $this->collection->mutateIn(
            $this->id,
            [new MutateArrayPrependSpec('', [$value], false, false, false)],
            $options
        );
    }

    public function clear(): void
    {
        try {
            $this->collection->remove($this->id, $this->options->removeOptions());
        } catch (DocumentNotFoundException $ex) {
            return;
        }
    }

    /**
     * @return Traversable<mixed, mixed>
     */
    public function getIterator(): Traversable
    {
        try {
            $result = $this->collection->get($this->id);

            if (null === $result->content()) {
                return new EmptyIterator();
            }

            return new ArrayIterator($result->content());
        } catch (DocumentNotFoundException $ex) {
            return new EmptyIterator();
        }
    }
}
