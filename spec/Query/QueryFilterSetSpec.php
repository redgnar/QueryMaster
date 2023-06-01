<?php

namespace spec\Redgnar\QueryMaster\Query;

use PhpSpec\ObjectBehavior;
use Redgnar\QueryMaster\Query\QueryFilterColumnOperator;
use Redgnar\QueryMaster\Query\QueryFilterSet;

class QueryFilterSetSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith([new QueryFilterColumnOperator(['test_value1'], '=', 'col1')]);
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
        $filter1Value->shouldBeAnInstanceOf(QueryFilterColumnOperator::class);
    }

    function it_allows_to_check_if_filters_are_set()
    {
        $this->hasFilter()->shouldBeBool();
        $this->hasFilter()->shouldBe(true);
    }
}
