<?php

declare(strict_types=1);

namespace spec\Redgnar\QueryMaster;

use PhpSpec\ObjectBehavior;
use Redgnar\QueryMaster\Query;
use Redgnar\QueryMaster\Query\QueryFilterSet;
use Redgnar\QueryMaster\Query\QuerySortSet;

class QuerySpec extends ObjectBehavior
{
    public function let(QueryFilterSet $filterSet, QuerySortSet $sortSet)
    {
        $this->beConstructedWith('uniqueId', 'dataSource', $filterSet, $sortSet);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Query::class);
    }

    public function it_allows_to_get_id()
    {
        $this->getId()->shouldBe('uniqueId');
    }

    public function it_allows_to_get_data_source()
    {
        $this->getDataSource()->shouldBe('dataSource');
    }

    public function it_allows_to_get_filters()
    {
        $this->getFilterSet()->shouldBeAnInstanceOf(QueryFilterSet::class);
    }

    public function it_allows_to_get_sorters()
    {
        $this->getSortSet()->shouldBeAnInstanceOf(QuerySortSet::class);
    }
}
