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
        $items = $this->data->find('.result-con');
        $data = [];
        /** @var simple_html_dom_node[] $items */
        foreach ($items as $item){
            $link = $item->find('.a-reset', 0) ?: $item->children(0);
            $url = $link ? $link->getAttribute('href') : '';
            $id = $this->getId($url);
            $result = $this->getResult(trim($item->find('.result-score', 0)->plaintext));
            $type = $this->getType(trim($item->find('.map-text', 0)->plaintext));
            $team1 = trim($item->find('.team', 0)->plaintext);
            $team2 = trim($item->find('.team', 1)->plaintext);
            $event = trim($item->find('.matchEventLogo', 0)->getAttribute('title'));
            $append = [
                'id' => $id,
                'status' => Match::STATUS_UPCOMING,
                'team1' => $team1,
                'team2' => $team2,
                'url' => $url,
                'type' => $type,
                'event' => $event,
                'result' => $result,
            ];
            $data[] = $append;
        }
        return $data;
    }

    protected function getResult($data)
    {
        $result = explode(' - ', $data);
        $r1 = $result[0];
        $r2 = $result[1];
        return [$r1 , $r2];
    }
}
