<?php

namespace spec\Redgnar\QueryMaster\MetaData;

use PhpSpec\ObjectBehavior;
use Redgnar\QueryMaster\MetaData\Column;

class ColumnSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('name', 'string');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Column::class);
    }

    function it_allows_to_get_name()
    {
        $this->getName()->shouldBe('name');
    }

    function it_allows_to_get_type()
    {
        $this->getType()->shouldBe('string');
    }
}
