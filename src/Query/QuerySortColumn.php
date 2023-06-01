<?php

namespace Redgnar\QueryMaster\Query;

class QuerySortColumn extends QuerySortBasic
{
    public function __construct(QuerySortDirection $direction, private readonly string $columnName)
    {
        parent::__construct($direction);
    }

    public function getColumnName(): string
    {
        return $this->columnName;
    }
}
