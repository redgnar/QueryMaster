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
            yield ['col1' => 'a', 'col2' => 1];
            yield ['col1' => 'b', 'col2' => 2];
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

    function it_fetch_results_from_data_source_base_on_query(DataSource\StaticData $dataSource, Query $query)
    {
        $query->getDataSource()->willReturn('source');
        $result = $this->execute($query);
        $result->shouldBeAnInstanceOf(QueryResult::class);
        $result->toArray()->shouldBe([
            ['col1' => 'a', 'col2' => 1],
            ['col1' => 'b', 'col2' => 2],
        ]);
        // Only after $result->generate or toArray was called
        $dataSource->getColumns()->shouldHaveBeenCalled();
        $dataSource->data()->shouldHaveBeenCalled();
    }

    function it_will_fail_if_query_has_invalid_source(DataSource $dataSource, Query $query)
    {
        $query->getDataSource()->willReturn('source_invalid');
        $this->shouldThrow(DataSourceNotFound::class)->duringExecute($query);
    }
}
