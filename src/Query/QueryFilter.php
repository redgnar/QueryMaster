<?php

declare(strict_types=1);

namespace Redgnar\QueryMaster\Query;

interface QueryFilter
{
    public function getValues(): array;
}