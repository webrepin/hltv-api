<?php
namespace HltvApi\Parsers;


/**
 * Class MatchDetailsParser
 * @package HltvApi\Parsers
 */
class MatchDetailsParser extends Parser
{

    const ODDS_PROVIDERS = [
        'egb-nolink',
    ];

    /**
     * Parse implementation of Parser base class. Should returning a row of match details data
     * @throws \Exception
     */
    public function parse() : array
    {
        foreach (static::ODDS_PROVIDERS as $name) {

            $selector = ".{$name} .odds-cell";
            $odds1 = $this->data->find($selector, 0);
            $odds2 = $this->data->find($selector, 2);

            if($odds1 && $odds2)  {
                $odds1 = (double) trim($odds1->text());
                $odds2 = (double) trim($odds2->text()) ;
                break;
            }
        }

        $maps = $this->data->find('.maps .mapholder');
        $mapsResult = [];
        $mapsNames = [];

        $time = $this->data->find('.timeAndEvent .countdown', 0)->text();

        foreach ($maps as $i => $map) {
            $mapN = $i + 1;
            $name = $map->find('.mapname', 0)->plaintext;
            $mapsNames["map{$mapN}name"] = $name;

            if( $map->find('.results', 0)) {
                $resultLeft = $map->find('.results-left .results-team-score', 0)->plaintext;
                $resultRight = $map->find('.results-right .results-team-score', 0)->plaintext;
                $resultLeft = trim($resultLeft);
                $resultRight = trim($resultRight);
                $mapsResult["map{$mapN}score1"] = $resultLeft;
                $mapsResult["map{$mapN}score2"] = $resultRight;
            }

        }

        $result = [
            'odds' => [$odds1, $odds2],
            'time_start' => $time
        ];

        return array_merge($result, $mapsResult, $mapsNames);
    }

}