<?php

declare(strict_types=1);

namespace Redgnar\QueryMaster;

use Redgnar\QueryMaster\MetaData\Column;

interface DataSource
{
    /**
     * @return Column[]
     */
    public function getColumns(): array;
}
