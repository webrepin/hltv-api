<?php
namespace HltvApi\Parsers;


use HltvApi\Entity\Match;
use simplehtmldom_1_5\simple_html_dom_node;

/**
 * Class UpcomingParser
 * @package HltvApi\Parsers
 */
class UpcomingParser extends Parser
{

    protected $days = 1;

    /**
     * Parse implementation of Parser class. Should returning a rows of match data
     * @throws \Exception
     */
    public function parse() : array
    {
        if(!$this->days) {
            throw new \Exception('UpcomingParser expect integer count of days more then 0');
        }

        $idx = 0;
        $items = [];
        while ($idx < $this->days) {
            $idx++;
            $day = $this->data->find('.upcoming-matches .match-day',0);
            $items = array_merge($items, $day->find(' .upcoming-match'));
        }

        $data = [];
        /** @var simple_html_dom_node[] $items */
        foreach ($items as $item){
            $url = $item->find('.a-reset', 0)->getAttribute('href');
            $id = $this->getId($url);
            $type = $this->getType(trim($item->find('.map-text', 0)->plaintext));
            $team1 = trim($item->find('.team-cell', 0)->plaintext);
            $team2 = trim($item->find('.team-cell', 1)->plaintext);
            $event = trim(trim($item->find('.event-name', 0)->plaintext));
            $timestamp = ((int)$item->find('div.time', 0)->getAttribute('data-unix') / 1000);
            $append = [
                'id' => $id,
                'status' => Match::STATUS_UPCOMING,
                'team1' => $team1,
                'team2' => $team2,
                'url' => $url,
                'type' => $type,
                'event' => $event,
                'timestamp' => $timestamp,
            ];
            $data[] = $append;
        }
        return $data;
    }

    public function setDays(int $days)
    {
        $this->days = $days;
    }
}