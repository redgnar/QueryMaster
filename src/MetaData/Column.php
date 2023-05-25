<?php

namespace Redgnar\QueryMaster\MetaData;

class Column
{
    public function __construct(private readonly string $name, private readonly string $type)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }
}
