<?php

namespace Redgnar\QueryMaster\DataSource;

use Redgnar\QueryMaster\DataSource;
use Redgnar\QueryMaster\MetaData\Column;
use Redgnar\QueryMaster\MetaData\UnknownType;

class StaticData implements DataSource
{
    /**
     * @param \Closure $dataProvider should return array or \Generator that includes array<string, mixed>
     */
    public function __construct(private readonly \Closure $dataProvider)
    {
    }

    public function getColumns(): array
    {
        return $this->discoverFromRows($this->data());
    }

    public function data(): \Generator
    {
        $dataProvider = $this->dataProvider;

        yield from $dataProvider();
    }

    /**
     * @return Column[]
     *
     * @throws UnknownType
     */
    private function discoverFromRows(\Generator $rows): array
    {
        $columns = [];
        /** @var array<int, array<string, mixed>> $row */
        foreach ($rows as $row) {
            /**
             * @var string $columnName
             * @var mixed  $columnValue
             */
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
