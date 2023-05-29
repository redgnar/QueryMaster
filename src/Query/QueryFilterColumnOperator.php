<?php

namespace Redgnar\QueryMaster\Query;

class QueryFilterColumnOperator extends QueryFilterOperator
{
    /**
     * @param array<int, mixed> $values
     */
    public function __construct(array $values, string $operator, private readonly string $columnName)
    {
        parent::__construct($values, $operator);
    }

    public function getColumnName(): string
    {
        return $this->columnName;
    }
}
