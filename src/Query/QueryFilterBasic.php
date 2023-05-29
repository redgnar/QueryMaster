<?php

declare(strict_types=1);

namespace Redgnar\QueryMaster\Query;

abstract class QueryFilterBasic implements QueryFilter
{
    public function __construct(private readonly array $values)
    {
    }

    public function getValues(): array
    {
        return $this->values;
    }
}