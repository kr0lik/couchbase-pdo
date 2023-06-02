<?php

declare(strict_types=1);

namespace kr0lik\CouchbasePdo\Datastructures\Options;

use Couchbase\GetOptions;
use Couchbase\LookupInOptions;
use Couchbase\MutateInOptions;
use Couchbase\RemoveOptions;

class CouchbaseQueue
{
    private GetOptions $getOptions;
    private RemoveOptions $removeOptions;
    private LookupInOptions $lookupInOptions;
    private MutateInOptions $mutateInOptions;

    public function __construct(?GetOptions $get, ?RemoveOptions $remove, ?LookupInOptions $lookupIn, ?MutateInOptions $mutateIn)
    {
        $this->getOptions = $get ?? new GetOptions();
        $this->removeOptions = $remove ?? new RemoveOptions();
        $this->lookupInOptions = $lookupIn ?? new LookupInOptions();
        $this->mutateInOptions = $mutateIn ?? new MutateInOptions();
    }

    public function getOptions(): GetOptions
    {
        return $this->getOptions;
    }

    public function removeOptions(): RemoveOptions
    {
        return $this->removeOptions;
    }

    public function lookupInOptions(): LookupInOptions
    {
        return $this->lookupInOptions;
    }

    public function mutateInOptions(): MutateInOptions
    {
        return $this->mutateInOptions;
    }
}
