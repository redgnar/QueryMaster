<?php

namespace spec\Redgnar\QueryMaster\Query;

use PhpSpec\ObjectBehavior;
use Redgnar\QueryMaster\Query\QuerySortBasic;
use Redgnar\QueryMaster\Query\QuerySortDirection;

class QuerySortBasicSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(QuerySortDirection::ASC);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(QuerySortBasic::class);
    }

    function it_allows_to_get_direction()
    {
        $this->getDirection()->shouldBeAnInstanceOf(QuerySortDirection::class);
        $this->getDirection()->shouldBe(QuerySortDirection::ASC);
    }
}
