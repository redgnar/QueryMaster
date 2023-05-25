<?php

declare(strict_types=1);

namespace Redgnar\QueryMaster\Query;

class QueryResult
{
    public function __construct(private readonly \Closure $dataProvider)
    {
    }

    public function generate(): \Generator
    {
        yield from ($this->dataProvider)();
    }

    /**
     * @return array<int, mixed>
     */
    public function toArray(): array
    {
        return iterator_to_array($this->generate());
    }
}
