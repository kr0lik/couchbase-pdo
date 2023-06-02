<?php

declare(strict_types=1);

namespace kr0lik\CouchbasePdo\Options;

class RemoveOptions
{
    private ?string $cas = null;
    private ?int $durabilityLevel = null;
    private ?int $timeout = null;

    public function setTimeout(?int $timeout): self
    {
        $this->timeout = $timeout;

        return $this;
    }

    public function setDurabilityLevel(?int $durabilityLevel): self
    {
        $this->durabilityLevel = $durabilityLevel;

        return $this;
    }

    public function setCas(?string $cas): self
    {
        $this->cas = $cas;

        return $this;
    }

    public function getCas(): ?string
    {
        return $this->cas;
    }

    public function getDurabilityLevel(): ?int
    {
        return $this->durabilityLevel;
    }

    public function getTimeout(): ?int
    {
        return $this->timeout;
    }
}
