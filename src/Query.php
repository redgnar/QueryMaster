<?php

declare(strict_types=1);

namespace Redgnar\QueryMaster;

use Redgnar\QueryMaster\Query\QueryFilterSet;
use Redgnar\QueryMaster\Query\QuerySortSet;

class Query
{
    public function __construct(
        private readonly string $id,
        private readonly string $dataSource,
        private readonly QueryFilterSet $filterSet,
        private readonly QuerySortSet $sortSet,
    )
    {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getDataSource(): string
    {
        return $this->dataSource;
    }

    public function getFilterSet(): QueryFilterSet
    {
        return $this->filterSet;
    }

    public function getSortSet(): QuerySortSet
    {
        return $this->sortSet;
    }
}
