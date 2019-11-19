<?php

namespace tests\Entity;


use HltvApi\Client;
use HltvApi\Entity\Match;
use HltvApi\Entity\MatchDetails;
use PHPUnit\Framework\TestCase;

/**
 * Class MatchDetailsTest
 * @package tests\Entity
 */
class MatchDetailsTest extends TestCase
{

    /**
     * @dataProvider additionalData
     * @param array $data
     * @param array $expected
     */
    public function testMatchDetailsEntity(array $data, array $expected)
    {
        $match = new MatchDetails($data, new Client());
        $this->assertEquals($expected['id'], $match->getId());
    }

    /**
     * @return array
     */
    public function additionalData()
    {
        return [
            [
                'data' => [
                    'id' => '1',
                    'team1' => 't11',
                    'team2' => 't12',
                    'timestamp' => time(),
                ],
                'expected' => [
                    'id' => 1,
                    'team1' => 't11',
                    'team2' => 't12',
                    'timestamp' => time(),
                ]
            ],
            [
                'data' => [
                    'id' => '1',
                    'team1' => 't11',
                    'team2' => 't12',
                    'timestamp' => time(),
                ],
                'expected' => [
                    'id' => 1,
                    'team1' => 't11',
                    'team2' => 't12',
                    'timestamp' => time(),
                ]
            ],
        ];
    }
}