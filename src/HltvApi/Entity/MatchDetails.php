<?php
namespace HltvApi\Entity;

/**
 * Class MatchDetails
 * @package HltvApi\Entity
 */
class MatchDetails extends Match
{


    const IS_LIVE = 'LIVE';
    const IS_OVER = 'Match over';
    const IS_POSTPONED = 'Match postponed';

    /**
     * Getting a match -up type, declared in parent entity Match
     * @return null|int
     */
    public function getType()
    {
        return $this->getValue('type');
    }

    /**
     * Getting unix timestamp of match time
     * @return null|int
     */
    public function getMatchTimeStart()
    {
        return $this->getValue('time_start');
    }

    /**
     * @return null
     */
    public function getOdds()
    {
        return $this->getValue('odds');
    }

    /**
     * @param int $map
     * @return null
     */
    public function getMapStarted(int $map)
    {
        $score1 = $this->getValue("map{$map}score1", 0) ;
        $score2 = $this->getValue("map{$map}score2", 0);
        return $score1 + $score2 > 0;
    }

    /**
     * @param int $map
     * @return array | null
     */
    public function getMapResults(int $map)
    {
        $score1 = $this->getValue("map{$map}score1", 0);
        $score2 = $this->getValue("map{$map}score2", 0);
        if(($score1 != $score2) && ($score1 + $score2 < 30 )|| abs($score1 - $score2) > 3){
            return [$score1, $score2];
        }
        return null;
    }

    /**
     * @param int $map
     * @return array
     */
    public function getMapScore(int $map)
    {
        $score1 = $this->getValue("map{$map}score1", 0);
        $score2 = $this->getValue("map{$map}score2", 0);
        return [$score1, $score2];
    }

    /**
     * @param int $map
     * @return string
     */
    public function getMapName(int $map)
    {
        return $this->getValue("map{$map}name");
    }

    /**
     * @return boolean
     */
    public function getMatchIsLive()
    {
        return $this->getValue('time_start') == self::IS_LIVE;
    }

    /**
     * @return boolean
     */
    public function getMatchIsOver()
    {
        return $this->getValue('time_start') == self::IS_OVER;
    }
}