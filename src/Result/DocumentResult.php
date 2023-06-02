<?php

declare(strict_types=1);

namespace kr0lik\CouchbasePdo\Result;

use kr0lik\CouchbasePdo\Exception\CouchbaseException;

class DocumentResult implements ResultInterface
{
    private mixed $content = null;
    private ?string $cas = null;
    private ?CouchbaseException $error = null;

    public function content(): mixed
    {
        return $this->content;
    }

    public function error(): ?CouchbaseException
    {
        return $this->error;
    }

    public function getContent(): mixed
    {
        return $this->content;
    }

    public function setContent(mixed $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCas(): ?string
    {
        return $this->cas;
    }

    public function setCas(?string $cas): self
    {
        $this->cas = $cas;

        return $this;
    }

    public function getError(): ?CouchbaseException
    {
        return $this->error;
    }

    public function setError(?CouchbaseException $error): self
    {
        $this->error = $error;

        return $this;
    }
}
