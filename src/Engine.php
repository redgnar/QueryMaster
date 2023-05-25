<?php

declare(strict_types=1);

namespace Redgnar\QueryMaster;

use Redgnar\QueryMaster\Query\QueryResult;

interface Engine
{
    public function execute(Query $query): QueryResult;
}
