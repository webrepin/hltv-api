<?php

namespace tests\Wrappers;

use HltvApi\Client;
use HltvApi\Entity\Entity;
use HltvApi\Entity\Match;
use HltvApi\Entity\MatchDetails;
use HltvApi\Wrappers\BaseWrapper;
use PHPUnit\Framework\TestCase;

class BaseWrapperTest extends TestCase
{
    /**
     * @dataProvider dataProviderRow
     * @param $class
     * @param $data
     * @param $expected
     */
    public function testWrapperRow($class, $data, $expected)
    {
        $wrapper = new BaseWrapper($class, $data, new Client());
        $this->assertEquals($expected, $wrapper->fetchRow());
    }

    /**
     * @dataProvider dataProviderList
     * @param $class
     * @param $data
     * @param $expected
     */
    public function testWrapperList($class, $data, $expected)
    {
        $wrapper = new BaseWrapper($class, $data, new Client());
        $this->assertEquals($expected, $wrapper->fetchList());
    }

    /**
     * @return array
     */
    public function dataProviderRow()
    {
        return [
            [
                'class' => MatchDetails::class,
                'data' => ['id' => 1, 'team1' => 't1','team2' => 't2'],
                'expected' => new MatchDetails(['id' => 1, 'team1' => 't1','team2' => 't2'], new Client())
            ],
            [
                'class' => MatchDetails::class,
                'data' => ['id' => 1, 'team1' => 'G2','team2' => 'Navi'],
                'expected' => new MatchDetails(['id' => 1, 'team1' => 'G2','team2' => 'Navi'], new Client())
            ],
        ];
    }


    /**
     * @return array
     */
    public function dataProviderList()
    {
        return [
            [
                'class' => Match::class,
                'data' => [
                    ['id' => 1, 'team1' => 't1','team2' => 't2'],
                    ['id' => 2, 'team1' => 'Navi','team2' => 'G2'],
                ],
                'expected' => [
                    new Match(['id' => 1, 'team1' => 't1','team2' => 't2'], new Client()),
                    new Match(['id' => 2, 'team1' => 'Navi','team2' => 'G2'], new Client()),
                ]
            ],
        ];
    }
}