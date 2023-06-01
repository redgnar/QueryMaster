<?php

declare(strict_types=1);

namespace Redgnar\QueryMaster\Query;

class QueryFilterSet
{
    /**
     * @param QueryFilter[] $filters
     */
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

    public function hasFilter(): bool
    {
        return !empty($this->filters);
    }
}
