<?php
namespace HltvApi\Parsers;


use HltvApi\Entity\Match;
use simplehtmldom_1_5\simple_html_dom_node;

/**
 * Class OngoingParser
 * @package HltvApi\Parsers
 */
class OngoingParser extends Parser
{
    /**
     * Return match type look for Match const
     *
     * @param $type
     * @return int|null
     */
    public function getType($type) : int
    {
        $lt = null;
        switch ($type) {
            case 'Best of 5':
                $lt = Match::TYPE_BO5;
                break;
            case 'Best of 3':
                $lt = Match::TYPE_BO3;
                break;
            case 'Best of 2':
                $lt = Match::TYPE_BO2;
                break;
            case 'Best of 1':
                $lt = Match::TYPE_BO1;
                break;
            default:
                $lt = Match::TYPE_UNDEFINED;
            break;
        }

        return $lt;
    }

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
            $type = $this->getType(trim($item->find('.bestof', 0)->plaintext));
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