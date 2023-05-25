<?php

namespace spec\Redgnar\QueryMaster\Query;

use PhpSpec\ObjectBehavior;
use Redgnar\QueryMaster\Query\QueryResult;

class QueryResultSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(function (){
            yield from [1,2,3];
        });
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(QueryResult::class);
    }

    function it_allows_iterate_by_generator()
    {
        $this->generate()->shouldBeAnInstanceOf(\Generator::class);
    }

    function it_allows_to_get_array_with_data()
    {
        $this->toArray()->shouldBe([1,2,3]);
    }
}
