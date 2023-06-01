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
            $sortSet = $query->getSortSet();
            if (!$sortSet->hasSort()) {
                /** @var array<string, mixed> $row */
                foreach ($queryDataSource->data() as $row) {
                    if (!$this->matchToFilterSet($filterSet, $row)) {
                        continue;
                    }
                    yield $row;
                }
            } else {
                $filteredRows = [];
                /** @var array<string, mixed> $row */
                foreach ($queryDataSource->data() as $row) {
                    if (!$this->matchToFilterSet($filterSet, $row)) {
                        continue;
                    }
                    $filteredRows[] = $row;
                }

                yield from $this->sortBySortSet($sortSet, $filteredRows);
            }
        });
    }

    /**
     * @param array<string, mixed> $row
     */
    private function matchToFilterSet(QueryFilterSet $filterSet, array $row): bool
    {
        foreach ($filterSet->getFilters() as $filter) {
            if (!$this->matchToFilter($filter, $row)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param array<string, mixed> $row
     */
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

    /**
     * @param array<int, array<string, mixed>> $filteredRows
     *
     * @return array<int, array<string, mixed>>
     */
    private function sortBySortSet(Query\QuerySortSet $sortSet, array $filteredRows): array
    {
        $sortedRows = $filteredRows;
        /** @var Query\QuerySort $sort */
        foreach ($sortSet->getSorters() as $sort) {
            if ($sort instanceof Query\QuerySortColumn) {
                $columnName = $sort->getColumnName();
                $direction = $sort->getDirection();
                usort($sortedRows, function (array $row1, array $row2) use ($direction, $columnName) {
                    $a = $row1[$columnName] ?? null;
                    $b = $row2[$columnName] ?? null;
                    $directionValue = Query\QuerySortDirection::ASC === $direction ? 1 : -1;
                    if ($a === $b) {
                        return 0;
                    }

                    return ($a < $b) ? -$directionValue : $directionValue;
                });
            }
        }

        return $sortedRows;
    }
}
