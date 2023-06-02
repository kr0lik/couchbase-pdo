<?php

declare(strict_types=1);

namespace kr0lik\CouchbasePdo;

class Helper
{
    public static function isNotNull(mixed $value): bool
    {
        return null !== $value;
    }
}
