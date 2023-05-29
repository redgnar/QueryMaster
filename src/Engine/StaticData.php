<?php

declare(strict_types=1);

namespace Redgnar\QueryMaster\Engine;

use Redgnar\QueryMaster\DataSource;
use Redgnar\QueryMaster\Engine;
use Redgnar\QueryMaster\Query;
use Redgnar\QueryMaster\Query\QueryFilter;
use Redgnar\QueryMaster\Query\QueryFilterSet;
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

        return new QueryResult(function () use ($queryDataSource, $query) {
            $filterSet = $query->getFilterSet();
            foreach ($queryDataSource->data() as $row) {
                if (!$this->matchToFilterSet($filterSet, $row)) {
                    continue;
                }
                yield $row;
            }
        });
    }

    private function matchToFilterSet(QueryFilterSet $filterSet, array $row): bool
    {
        foreach ($filterSet->getFilters() as $filter) {
            if (!$this->matchToFilter($filter, $row)) {
                return false;
            }
        }

        return true;
    }

    private function matchToFilter(QueryFilter $filter, $row): bool
    {
        if ($filter instanceof Query\QueryFilterColumnOperator) {
            $columnName = $filter->getColumnName();
            $operator = $filter->getOperator();
            $rowValue = $row[$columnName] ?? null;
            foreach ($filter->getValues() as $value) {
                $result = true;
                switch ($operator) {
                    case '=':
                        $result = $rowValue === $value;
                        break;
                    case '<':
                        $result = $rowValue < $value;
                        break;
                    case '<=':
                        $result = $rowValue <= $value;
                        break;
                    case '>':
                        $result = $rowValue > $value;
                        break;
                    case '>=':
                        $result = $rowValue >= $value;
                        break;
                    case '!=':
                        $result = $rowValue !== $value;
                        break;
                    case '~':
                        if (is_string($rowValue) && is_string($value)) {
                            $result = false !== stripos($rowValue, $value);
                        } else {
                            $result = false;
                        }
                        break;
                }
                if (!$result) {
                    return false;
                }
            }
        }

        return true;
    }
}
