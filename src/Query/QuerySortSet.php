<?php

declare(strict_types=1);

namespace Redgnar\QueryMaster\Query;

class QuerySortSet
{
    /**
     * @param QuerySort[] $sorters
     */
    public function __construct(private readonly array $sorters)
    {
    }

    /**
     * @return QuerySort[]
     */
    public function getSorters(): array
    {
        return $this->sorters;
    }

    public function hasSort(): bool
    {
        return !empty($this->sorters);
    }
}
