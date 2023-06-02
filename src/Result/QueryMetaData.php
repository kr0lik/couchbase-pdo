<?php

declare(strict_types=1);

namespace kr0lik\CouchbasePdo\Result;

class QueryMetaData
{
    private ?string $status = null;
    private ?string $requestId = null;
    private ?string $clientContextId = null;
    /**
     * @var array<string>|null
     */
    private ?array $signature = null;
    /**
     * @var array<string>|null
     */
    private ?array $warnings = null;
    /**
     * @var array<string>|null
     */
    private ?array $errors = null;
    /**
     * @var array<string, string|int>|null
     */
    private ?array $metrics = null;

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function getRequestId(): ?string
    {
        return $this->requestId;
    }

    public function getClientContextId(): ?string
    {
        return $this->clientContextId;
    }

    /**
     * @return array<string>|null
     */
    public function getSignature(): ?array
    {
        return $this->signature;
    }

    /**
     * @return array<string>|null
     */
    public function getWarnings(): ?array
    {
        return $this->warnings;
    }

    /**
     * @return array<string>|null
     */
    public function getErrors(): ?array
    {
        return $this->errors;
    }

    /**
     * @return array<string, string|int>|null
     */
    public function getMetrics(): ?array
    {
        return $this->metrics;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function setRequestId(?string $requestId): self
    {
        $this->requestId = $requestId;

        return $this;
    }

    public function setClientContextId(?string $clientContextId): self
    {
        $this->clientContextId = $clientContextId;

        return $this;
    }

    /**
     * @param mixed[]|null $signature
     */
    public function setSignature(?array $signature): self
    {
        $this->signature = $signature;

        return $this;
    }

    /**
     * @param mixed[]|null $warnings
     */
    public function setWarnings(?array $warnings): self
    {
        $this->warnings = $warnings;

        return $this;
    }

    /**
     * @param mixed[]|null $errors
     */
    public function setErrors(?array $errors): self
    {
        $this->errors = $errors;

        return $this;
    }

    /**
     * @param mixed[]|null $metrics
     */
    public function setMetrics(?array $metrics): self
    {
        $this->metrics = $metrics;

        return $this;
    }
}
