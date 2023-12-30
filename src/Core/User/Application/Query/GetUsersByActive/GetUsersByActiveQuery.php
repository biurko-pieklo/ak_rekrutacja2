<?php

namespace App\Core\User\Application\Query\GetUsersByActive;

class GetUsersByActiveQuery
{
    public function __construct(public readonly string $active)
    {
    }
}
