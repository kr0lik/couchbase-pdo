<?php

declare(strict_types=1);

namespace kr0lik\CouchbasePdo\Result;

class CommonResult implements ResultInterface
{
    private string $cas;

    public function __construct(string $cas)
    {
        $this->cas = $cas;
    }

    public function cas(): string
    {
        return $this->cas;
    }
}
