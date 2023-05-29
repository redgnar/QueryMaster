<?php

namespace spec\Redgnar\QueryMaster\Query;

use PhpSpec\ObjectBehavior;
use Redgnar\QueryMaster\Query\QueryFilterOperator;
use Redgnar\QueryMaster\Query\QueryFilterSet;

class QueryFilterSetSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(['filter1' => new QueryFilterOperator(['test_value1'], '=')]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(QueryFilterSet::class);
    }

    function it_allows_get_filters()
    {
        $result = $this->getFilters();

        $result->shouldBeArray();
        $result->shouldHaveKey('filter1');
        $filter1Value = $result['filter1'];
        $filter1Value->shouldBeAnInstanceOf(QueryFilterOperator::class);
    }
}
