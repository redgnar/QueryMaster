<?php

namespace spec\Redgnar\QueryMaster\Query;

use PhpSpec\ObjectBehavior;
use Redgnar\QueryMaster\Query\QueryFilterOperator;

class QueryFilterOperatorSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(['test_value1'], '=');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(QueryFilterOperator::class);
    }

    function it_alows_to_get_values()
    {
        $this->getValues()->shouldBe(['test_value1']);
    }

    function it_allows_to_get_operator()
    {
        $this->getOperator()->shouldBe('=');
    }
}