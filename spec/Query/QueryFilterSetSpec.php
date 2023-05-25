<?php

namespace spec\Redgnar\QueryMaster\Query;

use PhpSpec\ObjectBehavior;
use Redgnar\QueryMaster\Query\QueryFilterSet;

class QueryFilterSetSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(QueryFilterSet::class);
    }
}
