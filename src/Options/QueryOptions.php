<?php

declare(strict_types=1);

namespace kr0lik\CouchbasePdo\Options;

class QueryOptions
{
    private ?int $timeout = null;
    private ?int $scanConsistency = null;
    private ?int $scanCap = null;
    private ?int $pipelineCap = null;
    private ?int $pipelineBatch = null;
    private ?int $maxParallelism = null;
    private ?bool $readonly = null;
    private ?bool $flexIndex = null;
    private ?bool $adhoc = null;
    /**
     * @var array<mixed>|null
     */
    private ?array $namedParameters = null;
    /**
     * @var array<mixed>|null
     */
    private ?array $positionalParameters = null;
    /**
     * @var array<string, mixed>|null
     */
    private ?array $raw = null;
    private ?string $clientContextId = null;
    private ?bool $metrics = null;
    private ?string $scopeName = null;
    private ?string $scopeQualifier = null;

    public function setTimeout(?int $timeout): self
    {
        $this->timeout = $timeout;

        return $this;
    }

    public function setScanConsistency(?int $scanConsistency): self
    {
        $this->scanConsistency = $scanConsistency;

        return $this;
    }

    public function setScanCap(?int $scanCap): self
    {
        $this->scanCap = $scanCap;

        return $this;
    }

    public function setPipelineCap(?int $pipelineCap): self
    {
        $this->pipelineCap = $pipelineCap;

        return $this;
    }

    public function setPipelineBatch(?int $pipelineBatch): self
    {
        $this->pipelineBatch = $pipelineBatch;

        return $this;
    }

    public function setMaxParallelism(?int $maxParallelism): self
    {
        $this->maxParallelism = $maxParallelism;

        return $this;
    }

    public function setReadonly(?bool $readonly): self
    {
        $this->readonly = $readonly;

        return $this;
    }

    public function setFlexIndex(?bool $flexIndex): self
    {
        $this->flexIndex = $flexIndex;

        return $this;
    }

    public function setAdhoc(?bool $adhoc): self
    {
        $this->adhoc = $adhoc;

        return $this;
    }

    /**
     * @param array<mixed>|null $namedParameters
     */
    public function setNamedParameters(?array $namedParameters): self
    {
        $this->namedParameters = $namedParameters;

        return $this;
    }

    /**
     * @param array<mixed>|null $positionalParameters
     */
    public function setPositionalParameters(?array $positionalParameters): self
    {
        $this->positionalParameters = $positionalParameters;

        return $this;
    }

    public function setRaw(string $key, mixed $value): self
    {
        $this->raw[$key] = $value;

        return $this;
    }

    public function setClientContextId(?string $clientContextId): self
    {
        $this->clientContextId = $clientContextId;

        return $this;
    }

    public function setMetrics(?bool $metrics): self
    {
        $this->metrics = $metrics;

        return $this;
    }

    public function setScopeName(?string $scopeName): self
    {
        $this->scopeName = $scopeName;

        return $this;
    }

    public function setScopeQualifier(?string $scopeQualifier): self
    {
        $this->scopeQualifier = $scopeQualifier;

        return $this;
    }

    public function getTimeout(): ?int
    {
        return $this->timeout;
    }

    public function getScanConsistency(): ?int
    {
        return $this->scanConsistency;
    }

    public function getScanCap(): ?int
    {
        return $this->scanCap;
    }

    public function getPipelineCap(): ?int
    {
        return $this->pipelineCap;
    }

    public function getPipelineBatch(): ?int
    {
        return $this->pipelineBatch;
    }

    public function getMaxParallelism(): ?int
    {
        return $this->maxParallelism;
    }

    public function isReadonly(): ?bool
    {
        return $this->readonly;
    }

    public function isFlexIndex(): ?bool
    {
        return $this->flexIndex;
    }

    public function isAdhoc(): ?bool
    {
        return $this->adhoc;
    }

    /**
     * @return array<mixed>
     */
    public function getNamedParameters(): ?array
    {
        return $this->namedParameters;
    }

    /**
     * @return array<mixed>
     */
    public function getPositionalParameters(): ?array
    {
        return $this->positionalParameters;
    }

    /**
     * @return array<string, mixed>
     */
    public function getRaw(): ?array
    {
        return $this->raw;
    }

    public function getClientContextId(): ?string
    {
        return $this->clientContextId;
    }

    public function isMetrics(): ?bool
    {
        return $this->metrics;
    }

    public function getScopeName(): ?string
    {
        return $this->scopeName;
    }

    public function getScopeQualifier(): ?string
    {
        return $this->scopeQualifier;
    }
}
