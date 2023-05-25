<?php

namespace spec\Redgnar\QueryMaster\DataSource;

use PhpSpec\ObjectBehavior;
use Redgnar\QueryMaster\DataSource;
use Redgnar\QueryMaster\MetaData\Column;

class StaticDataSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(function() {
            yield ['col1' => 'a', 'col2' => 1];
            yield ['col1' => 'b', 'col2' => 2];
        });
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(DataSource::class);
    }

    function it_shows_data_as_generator()
    {
        $result = $this->data();
        $result->shouldBeAnInstanceOf(\Generator::class);
        $result->shouldYield(new \ArrayIterator([['col1' => 'a', 'col2' => 1], ['col1' => 'b', 'col2' => 2]]));

        $columns = $this->getColumns();
        $columns->shouldBeArray();
        $columns->shouldHaveKey('col1');
        $columns['col1']->shouldBeAnInstanceOf(Column::class);
        $columns['col1']->getName()->shouldBe('col1');
        $columns['col1']->getType()->shouldBe('string');
        $columns->shouldHaveKey('col2');
        $columns['col2']->shouldBeAnInstanceOf(Column::class);
        $columns['col2']->getName()->shouldBe('col2');
        $columns['col2']->getType()->shouldBe('integer');
    }
}