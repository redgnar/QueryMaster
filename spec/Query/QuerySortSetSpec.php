<?php

namespace spec\Redgnar\QueryMaster\Query;

use PhpSpec\ObjectBehavior;
use Redgnar\QueryMaster\Query\QueryFilterColumnOperator;
use Redgnar\QueryMaster\Query\QuerySortColumn;
use Redgnar\QueryMaster\Query\QuerySortDirection;
use Redgnar\QueryMaster\Query\QuerySortSet;

class QuerySortSetSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith([new QuerySortColumn(QuerySortDirection::ASC, 'col1')]);
    }
    function it_is_initializable()
    {
        $this->shouldHaveType(QuerySortSet::class);
    }

    function it_allows_get_filters()
    {
        $result = $this->getSorters();

        $result->shouldBeArray();
        $result->shouldHaveKey(0);
        $filter1Value = $result[0];
        $filter1Value->shouldBeAnInstanceOf(QuerySortColumn::class);
    }

    function it_allows_to_check_if_sorters_are_set()
    {
        $this->hasSort()->shouldBeBool();
        $this->hasSort()->shouldBe(true);
    }
}
