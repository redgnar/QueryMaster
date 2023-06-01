<?php

namespace spec\Redgnar\QueryMaster\Query;

use PhpSpec\ObjectBehavior;
use Redgnar\QueryMaster\Query\QuerySortColumn;
use Redgnar\QueryMaster\Query\QuerySortDirection;

class QuerySortColumnSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(QuerySortDirection::ASC, 'col1');
    }
    function it_is_initializable()
    {
        $this->shouldHaveType(QuerySortColumn::class);
    }

    function it_allows_to_get_column_name()
    {
        $this->getColumnName()->shouldBe('col1');
    }
}
