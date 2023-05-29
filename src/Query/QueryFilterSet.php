<?php

declare(strict_types=1);

namespace Redgnar\QueryMaster\Query;

class QueryFilterSet
{
    public function __construct(private readonly array $filters)
    {
    }

    /**
     * @return QueryFilter[]
     */
    public function getFilters(): array
    {
        return $this->filters;
    }
}
