<?php

declare(strict_types=1);

namespace Redgnar\QueryMaster\Query;

class QueryFilterOperator extends QueryFilterBasic
{
    /**
     * @param array<int, mixed> $values
     */
    public function __construct(array $values, private readonly string $operator)
    {
        parent::__construct($values);
    }

    public function getOperator(): string
    {
        return $this->operator;
    }
}
