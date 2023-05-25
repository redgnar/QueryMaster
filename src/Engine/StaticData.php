<?php

namespace Redgnar\QueryMaster\Engine;

use Redgnar\QueryMaster\DataSource;
use Redgnar\QueryMaster\Engine;
use Redgnar\QueryMaster\Query;
use Redgnar\QueryMaster\Query\QueryResult;

class StaticData implements Engine
{
    use DataSourceRegistry;

    protected function checkSupport(string $dataSourceName, DataSource $queryDataSource): void
    {
        if (!($queryDataSource instanceof DataSource\StaticData)) {
            throw new \InvalidArgumentException('Data Source not supported. NAME: '.$dataSourceName);
        }
    }

    public function execute(Query $query): QueryResult
    {
        /** @var DataSource\StaticData $queryDataSource */
        $queryDataSource = $this->getDataSource($query->getDataSource());
        $columns = $queryDataSource->getColumns();
        $data = $queryDataSource->data();

        return new QueryResult(function () use ($data) {
            yield from $data;
        });
    }
}
