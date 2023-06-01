<?php

declare(strict_types=1);

namespace Redgnar\QueryMaster\Query;

interface QuerySort
{
    public function getDirection(): QuerySortDirection;
}
