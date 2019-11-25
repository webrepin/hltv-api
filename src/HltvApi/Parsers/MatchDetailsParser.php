<?php
namespace HltvApi\Parsers;


/**
 * Class MatchDetailsParser
 * @package HltvApi\Parsers
 */
class MatchDetailsParser extends Parser
{

    /**
     * Parse implementation of Parser base class. Should returning a row of match details data
     * @throws \Exception
     */
    public function parse() : array
    {

        $odds1 = $this->data->find('.betting-listing .egb-nolink .odds-cell', 0);
        $odds2 = $this->data->find('.betting-listing .egb-nolink .odds-cell', 2);

        if($odds1 && $odds2)  {
            $odds1 = (double) trim($odds1->text());
            $odds2 = (double) trim($odds2->text()) ;
        }

        $maps = $this->data->find('.maps .mapholder');
        $mapsResult = [];
        $mapsNames = [];

        $time = $this->data->find('.timeAndEvent .countdown', 0)->text();

        foreach ($maps as $i => $map) {
            $i++;

            $name = $map->find('.mapname', 0)->plaintext;
            $mapsNames["map{$i}name"] = $name;

            $result = $map->find('.results', 0)->plaintext;
            $result = explode('(', $result);
            $result = isset($result[0]) ? $result[0] : null;
            if($result) {
                $result = explode(':', $result);
            }

            $mapsResult["map{$i}score1"] = isset($result[0]) ? $result[0] : null;
            $mapsResult["map{$i}score2"] = isset($result[1]) ? $result[1] : null;
        }

        $result = [
            'odds' => [$odds1, $odds2],
            'time_start' => $time
        ];

        return array_merge($result, $mapsResult, $mapsNames);
    }

}