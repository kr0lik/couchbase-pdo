<?php

declare(strict_types=1);

namespace kr0lik\CouchbasePdo\Options;

class ReplaceOptions
{
    /**
     * @var callable|null
     */
    private $encoder;
    private ?int $timeout = null;
    private ?int $durabilityLevel = null;
    private ?int $expiry = null;
    private ?int $replicateTo = null;
    private ?int $persistTo = null;

    public function setTimeout(?int $timeout): self
    {
        $this->timeout = $timeout;

        return $this;
    }

    public function setExpiry(?int $expiry): self
    {
        $this->expiry = $expiry;

        return $this;
    }

    public function setDurabilityLevel(?int $durabilityLevel): self
    {
        $this->durabilityLevel = $durabilityLevel;

        return $this;
    }

    public function setEncoder(?callable $encoder): self
    {
        $this->encoder = $encoder;

        return $this;
    }

    public function getTimeout(): ?int
    {
        return $this->timeout;
    }

    public function getEncoder(): ?callable
    {
        return $this->encoder;
    }

    public function getDurabilityLevel(): ?int
    {
        return $this->durabilityLevel;
    }

    public function getExpiry(): ?int
    {
        return $this->expiry;
    }

    public function getReplicateTo(): ?int
    {
        return $this->replicateTo;
    }

    public function setReplicateTo(?int $replicateTo): self
    {
        $this->replicateTo = $replicateTo;

        return $this;
    }

    public function getPersistTo(): ?int
    {
        return $this->persistTo;
    }

    public function setPersistTo(?int $persistTo): self
    {
        $this->persistTo = $persistTo;

        return $this;
    }
}
