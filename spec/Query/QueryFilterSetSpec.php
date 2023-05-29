<?php

namespace spec\Redgnar\QueryMaster\Query;

use PhpSpec\ObjectBehavior;
use Redgnar\QueryMaster\Query\QueryFilterOperator;
use Redgnar\QueryMaster\Query\QueryFilterSet;

class QueryFilterSetSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith([new QueryFilterOperator(['test_value1'], '=')]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(QueryFilterSet::class);
    }

    function it_allows_get_filters()
    {
        $result = $this->getFilters();

        $result->shouldBeArray();
        $result->shouldHaveKey(0);
        $filter1Value = $result[0];
        $filter1Value->shouldBeAnInstanceOf(QueryFilterOperator::class);
    }
}
