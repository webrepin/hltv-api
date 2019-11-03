<?php

namespace tests\Entity;


use HltvApi\Entity\Match;
use HltvApi\Entity\MatchDetails;
use PHPUnit\Framework\TestCase;

/**
 * Class MatchTest
 * @package tests\Entity
 */
class MatchTest extends TestCase
{
    /**
     * @dataProvider additionalData
     */
    public function testMatchEntity(array $data, array $expected)
    {
        $match = new Match($data);
        $this->assertEquals($expected['id'], $match->getId());
        $this->assertEquals($expected['team1'], $match->getTeam1());
        $this->assertEquals($expected['team2'], $match->getTeam2());
        $this->assertEquals($expected['timestamp'], $match->getTimestamp());
    }

    /**
     * @dataProvider additionalData
     * @requires testMatchEntity
     */
    public function testMatchDetailsEntity(array $data, array $expected)
    {
        $match = new MatchDetails($data);
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