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
            $items = array_merge($items, $this->data->find('.upcomingMatch')); 
        }

        $data = [];
        /** @var simple_html_dom_node[] $items */
        foreach ($items as $item){
            $link = $item->find('.a-reset', 0);
            $url = $link ? $link->getAttribute('href') : '';
            $id = $this->getId($url);
            $type = $this->getType(trim($item->find('.matchMeta', 0)->plaintext));
            $team1 = trim($item->find('.matchTeamName', 0)->plaintext);
            if (!$team1) {
                $team1 = trim($item->find('.team1 .team', 0)->plaintext);
            }
            $team2 = trim($item->find('.matchTeamName', 1)->plaintext);
            if (!$team2) {
                $team2 = trim($item->find('.team2 .team', 0)->plaintext);
            }
            $event = trim($item->find('.matchEventLogo', 0)->getAttribute('title'));
            $timestamp = ((int)$item->find('.matchTime', 0)->getAttribute('data-unix') / 1000);
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
