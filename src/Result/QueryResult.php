<?php

declare(strict_types=1);

namespace kr0lik\CouchbasePdo\Result;

class QueryResult implements ResultInterface
{
    /**
     * @var array<mixed>|null
     */
    private ?array $rows = null;
    private ?QueryMetaData $meta = null;

    public function getMeta(): ?QueryMetaData
    {
        return $this->meta;
    }

    /**
     * @return mixed[]|null
     */
    public function getRows(): ?array
    {
        return $this->rows;
    }

    /**
     * @param mixed[]|null $rows
     */
    public function setRows(?array $rows): self
    {
        $this->rows = $rows;

        return $this;
    }

    public function setMeta(?QueryMetaData $meta): self
    {
        $this->meta = $meta;

        return $this;
    }
}
