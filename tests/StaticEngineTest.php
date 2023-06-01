<?php

declare(strict_types=1);

namespace Tests\Redgnar\QueryMaster;

use PHPUnit\Framework\TestCase;
use Redgnar\QueryMaster\Engine\StaticData;
use Redgnar\QueryMaster\Query;

class StaticEngineTest extends TestCase
{
    private StaticData $staticDataEngine;

    protected function setUp(): void
    {
        $this->staticDataEngine = new StaticData();
        $this->staticDataEngine->registerDataSource('testSource1',
            new \Redgnar\QueryMaster\DataSource\StaticData(function () {
                yield ['col1' => 'abc', 'col2' => 1];
                yield ['col1' => 'bcd', 'col2' => 2];
                yield ['col1' => 'cde', 'col2' => 3];
                yield ['col1' => 'def', 'col2' => 4];
                yield ['col1' => 'efg', 'col2' => 5];
            })
        );
    }

    public function testFetchFilteredSorted(): void
    {
        $query = new Query('queryId', 'testSource1',
            new Query\QueryFilterSet([new Query\QueryFilterColumnOperator([3], '>=', 'col2')]),
            new Query\QuerySortSet([new Query\QuerySortColumn(Query\QuerySortDirection::DESC, 'col1')])
        );
        $result = $this->staticDataEngine->execute($query);
        $resultAsArray = $result->toArray();
        self::assertIsArray($resultAsArray);
        self::assertNotEmpty($resultAsArray);
        self::assertEquals([
            ['col1' => 'efg', 'col2' => 5],
            ['col1' => 'def', 'col2' => 4],
            ['col1' => 'cde', 'col2' => 3],
        ], $resultAsArray);
    }
}
