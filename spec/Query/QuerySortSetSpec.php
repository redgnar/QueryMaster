<?php

namespace spec\Redgnar\QueryMaster\Query;

use PhpSpec\ObjectBehavior;
use Redgnar\QueryMaster\Query\QuerySortSet;

class QuerySortSetSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(QuerySortSet::class);
    }
}
