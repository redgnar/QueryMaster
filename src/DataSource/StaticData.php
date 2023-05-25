<?php

namespace Redgnar\QueryMaster\DataSource;

use Redgnar\QueryMaster\DataSource;
use Redgnar\QueryMaster\MetaData\Column;
use Redgnar\QueryMaster\MetaData\UnknownType;

class StaticData implements DataSource
{
    public function getColumns(): array
    {
        return $this->discoverFromRows($this->data());
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function data(): array
    {
        return [];
    }

    /**
     * @param array<int, array<string, mixed>> $rows
     *
     * @return Column[]
     *
     * @throws UnknownType
     */
    private function discoverFromRows(array $rows): array
    {
        $columns = [];
        foreach ($rows as $row) {
            foreach ($row as $columnName => $columnValue) {
                if (array_key_exists($columnName, $columns) || null === $columnValue) {
                    continue;
                }

                $columns[$columnName] = new Column($columnName, $this->discoverTypeFromValue($columnValue));
            }
        }

        return $columns;
    }

    private function discoverTypeFromValue(mixed $value): string
    {
        if (is_string($value)) {
            return 'string';
        }
        if (is_int($value)) {
            return 'integer';
        }
        if (is_float($value)) {
            return 'float';
        }
        if (is_bool($value)) {
            return 'bool';
        }
        if ($value instanceof \DateTime) {
            return 'datetime';
        }

        throw new UnknownType('Can not discover type of '.var_export($value, true));
    }
}
