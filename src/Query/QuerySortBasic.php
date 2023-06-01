<?php

namespace Redgnar\QueryMaster\Query;

class QuerySortBasic implements QuerySort
{
    public function __construct(private readonly QuerySortDirection $direction)
    {
    }

    public function getDirection(): QuerySortDirection
    {
        return $this->direction;
    }
}
