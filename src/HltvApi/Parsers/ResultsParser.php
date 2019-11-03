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
     */
    public function parse() : array
    {
        $items = $this->data->find('.live-matches .live-match .a-reset');

        $data = [];
        /** @var simple_html_dom_node[] $items */
        foreach ($items as $item){
            $url = $item->getAttribute('href');
            $id = $this->getId($url);
            $type = $this->getType($team1 = trim($item->find('.bestof', 0)->plaintext));
            $team1 = trim($item->find('.teams .team-name', 0)->plaintext);
            $team2 = trim($item->find('.teams .team-name', 1)->plaintext);
            $append = [
                'id' => $id,
                'status' => Match::STATUS_ONGOING,
                'team1' => $team1,
                'team2' => $team2,
                'url' => $url,
                'type' => $type,
            ];
            $data[] = $append;
        }
        return $data;
    }
}