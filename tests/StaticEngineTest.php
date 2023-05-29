<?php

declare(strict_types=1);

namespace tests\Redgnar\QueryMaster;

use Redgnar\QueryMaster\Engine\StaticData;
use Redgnar\QueryMaster\Query;

class StaticEngineTest extends \PHPUnit\Framework\TestCase
{
    private readonly StaticData $staticDataEngine;

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

    public function testFetchAll(): void
    {
        $query = new Query('queryId', 'testSource1', new Query\QueryFilterSet([]), new Query\QuerySortSet());
        $result = $this->staticDataEngine->execute($query);
        $resultAsArray = $result->toArray();
        self::assertIsArray($resultAsArray);
        self::assertNotEmpty($resultAsArray);
        self::assertGreaterThan(4, count($resultAsArray));
    }

}
