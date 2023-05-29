<?php

declare(strict_types=1);

namespace Redgnar\QueryMaster\Query;

interface QueryFilter
{
    /**
     * @return array<int, mixed>
     */
    public function getValues(): array;
}
