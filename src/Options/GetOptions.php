<?php

declare(strict_types=1);

namespace kr0lik\CouchbasePdo\Options;

class GetOptions
{
    /**
     * @var callable|null
     */
    private $decoder;
    /**
     * @var string[]|null
     */
    private ?array $projects = null;
    private ?bool $expiry = null;
    private ?int $timeout = null;

    public function setTimeout(?int $timeout): self
    {
        $this->timeout = $timeout;

        return $this;
    }

    public function setExpiry(?bool $expiry): self
    {
        $this->expiry = $expiry;

        return $this;
    }

    /**
     * @param string[]|null $projects
     */
    public function setProjects(?array $projects): self
    {
        $this->projects = $projects;

        return $this;
    }

    public function setDecoder(?callable $decoder): self
    {
        $this->decoder = $decoder;

        return $this;
    }

    public function getTimeout(): ?int
    {
        return $this->timeout;
    }

    public function getExpiry(): ?bool
    {
        return $this->expiry;
    }

    /**
     * @return string[]|null
     */
    public function getProjects(): ?array
    {
        return $this->projects;
    }

    public function getDecoder(): ?callable
    {
        return $this->decoder;
    }
}
