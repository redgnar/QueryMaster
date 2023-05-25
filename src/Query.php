<?php

declare(strict_types=1);

namespace Redgnar\QueryMaster;

use Redgnar\QueryMaster\Query\QueryFilterSet;
use Redgnar\QueryMaster\Query\QuerySortSet;

class Query
{
    public function __construct(private readonly string $id, private readonly string $dataSource)
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

    public function getFilters(): QueryFilterSet
    {
        return new QueryFilterSet();
    }

    public function getSorters(): QuerySortSet
    {
        return new QuerySortSet();
    }
}
