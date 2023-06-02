<?php

declare(strict_types=1);

namespace kr0lik\CouchbasePdo\Options;

class DecrementOptions
{
    private ?int $expiry = null;
    private ?int $timeout = null;
    private ?int $initial = null;

    public function getExpiry(): ?int
    {
        return $this->expiry;
    }

    public function setExpiry(?int $expiry): self
    {
        $this->expiry = $expiry;

        return $this;
    }

    public function getTimeout(): ?int
    {
        return $this->timeout;
    }

    public function setTimeout(?int $timeout): self
    {
        $this->timeout = $timeout;

        return $this;
    }

    public function getInitial(): ?int
    {
        return $this->initial;
    }

    public function setInitial(?int $initial): self
    {
        $this->initial = $initial;

        return $this;
    }
}
