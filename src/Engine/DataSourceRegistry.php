<?php

declare(strict_types=1);

namespace Redgnar\QueryMaster\Engine;

use Redgnar\QueryMaster\DataSource;
use Redgnar\QueryMaster\DataSourceNotFound;

trait DataSourceRegistry
{
    /**
     * @var DataSource[]
     */
    private array $dataSources = [];

    public function registerDataSource(string $dataSourceName, DataSource $queryDataSource): void
    {
        $this->checkSupport($dataSourceName, $queryDataSource);
        $this->dataSources[$dataSourceName] = $queryDataSource;
    }

    public function unregisterDataSource(string $dataSourceName): void
    {
        if (!$this->hasDataSource($dataSourceName)) {
            return;
        }

        unset($this->dataSources[$dataSourceName]);
    }

    public function hasDataSource(string $dataSourceName): bool
    {
        return isset($this->dataSources[$dataSourceName]);
    }

    public function getDataSource(string $dataSourceName): DataSource
    {
        if (!isset($this->dataSources[$dataSourceName])) {
            throw new DataSourceNotFound(sprintf('Data source $1%s not found', $dataSourceName));
        }

        return $this->dataSources[$dataSourceName];
    }

    protected function checkSupport(string $dataSourceName, DataSource $queryDataSource): void
    {
    }
}
