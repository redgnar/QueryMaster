<?php

namespace spec\Redgnar\QueryMaster\Engine;

use PhpSpec\ObjectBehavior;
use Redgnar\QueryMaster\DataSourceNotFound;
use Redgnar\QueryMaster\MetaData\Column;
use Redgnar\QueryMaster\Query;
use Redgnar\QueryMaster\Query\QueryResult;
use Redgnar\QueryMaster\Engine;
use Redgnar\QueryMaster\DataSource;

class StaticDataSpec extends ObjectBehavior
{
    function let(DataSource\StaticData $dataSource)
    {
        $this->beConstructedWith();
        $this->registerDataSource('source', $dataSource);
        $dataSource->data()->willReturn((function () {
            yield ['col1' => 'abc', 'col2' => 1];
            yield ['col1' => 'bcd', 'col2' => 2];
            yield ['col1' => 'cde', 'col2' => 3];
            yield ['col1' => 'def', 'col2' => 4];
            yield ['col1' => 'efg', 'col2' => 5];
        })());
        $dataSource->getColumns()->willReturn([
            'col1' => new Column('col1', 'string'),
            'col2' => new Column('col2', 'integer'),
        ]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Engine::class);
    }

    function it_allows_to_fetch_results_from_data_source_base_on_query(DataSource\StaticData $dataSource, Query $query)
    {
        $query->getDataSource()->willReturn('source');
        $query->getFilterSet()->willReturn(new Query\QueryFilterSet([]));
        $result = $this->execute($query);
        $result->shouldBeAnInstanceOf(QueryResult::class);
        $result->toArray()->shouldBe([
            ['col1' => 'abc', 'col2' => 1],
            ['col1' => 'bcd', 'col2' => 2],
            ['col1' => 'cde', 'col2' => 3],
            ['col1' => 'def', 'col2' => 4],
            ['col1' => 'efg', 'col2' => 5],
        ]);
        // Only after $result->generate or toArray was called
//        $dataSource->getColumns()->shouldHaveBeenCalled();
        $dataSource->data()->shouldHaveBeenCalled();
    }

    function it_will_fail_if_query_has_invalid_source(DataSource $dataSource, Query $query)
    {
        $query->getDataSource()->willReturn('source_invalid');
        $this->shouldThrow(DataSourceNotFound::class)->duringExecute($query);
    }

    function it_allows_to_fetch_results_from_data_source_base_on_query_with_equal_column_filter(DataSource\StaticData $dataSource, Query $query)
    {
        $query->getDataSource()->willReturn('source');
        $query->getFilterSet()->willReturn(new Query\QueryFilterSet([new Query\QueryFilterColumnOperator(['bcd'], '=', 'col1')]));
        $result = $this->execute($query);
        $result->shouldBeAnInstanceOf(QueryResult::class);
        $result->toArray()->shouldBe([
            ['col1' => 'bcd', 'col2' => 2],
        ]);
    }

    function it_allows_to_fetch_results_from_data_source_base_on_query_with_lower_column_filter(DataSource\StaticData $dataSource, Query $query)
    {
        $query->getDataSource()->willReturn('source');
        $query->getFilterSet()->willReturn(new Query\QueryFilterSet([new Query\QueryFilterColumnOperator([2], '<', 'col2')]));
        $result = $this->execute($query);
        $result->shouldBeAnInstanceOf(QueryResult::class);
        $result->toArray()->shouldBe([
            ['col1' => 'abc', 'col2' => 1],
        ]);
    }

    function it_allows_to_fetch_results_from_data_source_base_on_query_with_lower_equal_column_filter(DataSource\StaticData $dataSource, Query $query)
    {
        $query->getDataSource()->willReturn('source');
        $query->getFilterSet()->willReturn(new Query\QueryFilterSet([new Query\QueryFilterColumnOperator([2], '<=', 'col2')]));
        $result = $this->execute($query);
        $result->shouldBeAnInstanceOf(QueryResult::class);
        $result->toArray()->shouldBe([
            ['col1' => 'abc', 'col2' => 1],
            ['col1' => 'bcd', 'col2' => 2],
        ]);
    }

    function it_allows_to_fetch_results_from_data_source_base_on_query_with_greater_column_filter(DataSource\StaticData $dataSource, Query $query)
    {
        $query->getDataSource()->willReturn('source');
        $query->getFilterSet()->willReturn(new Query\QueryFilterSet([new Query\QueryFilterColumnOperator([3], '>', 'col2')]));
        $result = $this->execute($query);
        $result->shouldBeAnInstanceOf(QueryResult::class);
        $result->toArray()->shouldBe([
            ['col1' => 'def', 'col2' => 4],
            ['col1' => 'efg', 'col2' => 5],
        ]);
    }

    function it_allows_to_fetch_results_from_data_source_base_on_query_with_greater_equal_column_filter(DataSource\StaticData $dataSource, Query $query)
    {
        $query->getDataSource()->willReturn('source');
        $query->getFilterSet()->willReturn(new Query\QueryFilterSet([new Query\QueryFilterColumnOperator([3], '>=', 'col2')]));
        $result = $this->execute($query);
        $result->shouldBeAnInstanceOf(QueryResult::class);
        $result->toArray()->shouldBe([
            ['col1' => 'cde', 'col2' => 3],
            ['col1' => 'def', 'col2' => 4],
            ['col1' => 'efg', 'col2' => 5],
        ]);
    }

    function it_allows_to_fetch_results_from_data_source_base_on_query_with_like_all_column_filter(DataSource\StaticData $dataSource, Query $query)
    {
        $query->getDataSource()->willReturn('source');
        $query->getFilterSet()->willReturn(new Query\QueryFilterSet([new Query\QueryFilterColumnOperator(['b'], '~', 'col1')]));
        $result = $this->execute($query);
        $result->shouldBeAnInstanceOf(QueryResult::class);
        $result->toArray()->shouldBe([
            ['col1' => 'abc', 'col2' => 1],
            ['col1' => 'bcd', 'col2' => 2],
        ]);
    }
}
