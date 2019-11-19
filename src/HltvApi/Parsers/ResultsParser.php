<?php
namespace HltvApi\Parsers;


use HltvApi\Entity\Match;
use simplehtmldom_1_5\simple_html_dom_node;

/**
 * Class ResultsParser
 * @package HltvApi\Parsers
 */
class ResultsParser extends Parser
{
    /**
     * Parse implementation of Parser class. Should returning a rows of match data
     * @throws \Exception
     */
    public function parse() : array
    {
        $items = $this->data->find('.results-all .result-con .a-reset');
        $data = [];
        /** @var simple_html_dom_node[] $items */
        foreach ($items as $item){
            $url = $item->getAttribute('href');
            $id = $this->getId($url);
            $result = $this->getResult(trim($item->find('.result-score', 0)->text()));
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
                'result' => $result,
            ];
            $data[] = $append;
        }
        return $data;
    }

    protected function getResult($data)
    {
        $result = explode(' - ', $data);
        $r1 = (int)$result[0];
        $r2 = (int)$result[1];
        if($r1 > $r2) {
            return 1;
        } else if($r1 < $r2){
            return 2;
        } else {
            return null;
        }
    }
}