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
        'ggbet-odds',
        'onexbet-odds',
        'sts-intl',
        'skrilla-odds',
        'thunderfire-odds',
        'parimatch-odds',
        'unikrn-odds',
    ];

    /**
     * Parse implementation of Parser base class. Should returning a row of match details data
     * @throws \Exception
     */
    public function parse() : array
    {
        foreach (static::ODDS_PROVIDERS as $name) {

            $selector = ".betting-listing .{$name} .odds-cell";
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