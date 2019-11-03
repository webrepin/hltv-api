<?php
namespace tests;

use HltvApi\Client;
use HltvApi\Entity\Match;
use HltvApi\Parsers\OngoingParser;
use HltvApi\Parsers\UpcomingParser;
use function Humbug\get_contents;
use PHPUnit\Framework\TestCase;

/**
 * Class ClientTest
 * @package tests
 */
class ClientTest extends TestCase
{

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    public function makeClient()
    {
        $client = $this->getMockBuilder(Client::class)
            ->setMethods(['sendRequest'])
            ->disableOriginalConstructor()
            ->getMock();

        /*$client
            ->method('sendRequest')
            ->with($this->equalTo(Client::BASE_URL . '/results'))
            ->willReturn(get_contents('tests/data/results.html'));*/

        return $client;
    }

    /**
     * @dataProvider parserDataProvider
     *
     * @param $type
     * @param $expected
     * @return void
     * @throws \Exception
     */
    public function testDataParser($type, $expected) : void
    {
        /** @var Client $client */
        $client = $this->makeClient();
        $client
            ->method('sendRequest')
            ->with($this->equalTo(Client::BASE_URL . '/matches'))
            ->willReturn(get_contents('tests/data/matches.html'));

        $data = $client->createDataParser($type, Client::BASE_URL . '/matches')->parse();

        $this->assertEquals($expected, $data);
    }

    /**
     * @return array
     */
    public function parserDataProvider()
    {
        return [
            [OngoingParser::class, [
                    [
                        'id' => 2337403,
                        'status' => Match::STATUS_ONGOING,
                        'team1' => 'fnatic',
                        'team2' => 'Tricked',
                        'url' => '/matches/2337403/fnatic-vs-tricked-ecs-season-8-europe-week-5',
                        'type' => Match::TYPE_BO3,
                    ],

                ]
            ],
            [UpcomingParser::class, [
                [
                    'id' => 2337518,
                    'status' => Match::STATUS_UPCOMING,
                    'team1' => 'Spirit',
                    'team2' => 'HAVU',
                    'url' => '/matches/2337518/spirit-vs-havu-european-champions-cup',
                    'type' => Match::TYPE_BO3,
                    'event' => 'European Champions Cup',
                    'timestamp' => 1572464700,
                ],
            ]
            ],
        ];
    }


//    /**
//     * @return void
//     */
//    public function testUpcomingMatches() : void
//    {
//        $client = $this->makeClient();
//        $this->assertSame(get_contents('data/upcoming.html'), $client->createRequest());
//        $this->assertNotEmpty($client->upcomingMatchesList());
//
//    }

}