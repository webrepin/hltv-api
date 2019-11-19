<?php
namespace HltvApi\Entity;


/**
 * Class Match
 * @package HltvApi\Entity
 */
class Match extends Entity
{

    const STATUS_UPCOMING   = 1;
    const STATUS_ONGOING    = 2;
    const STATUS_PASSED     = 3;

    const TYPE_UNDEFINED = -1;
    const TYPE_BO1 = 1;
    const TYPE_BO2 = 2;
    const TYPE_BO3 = 3;
    const TYPE_BO5 = 4;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->getValue('id');
    }

    /**
     * @return string
     */
    public function getTeam1() : string
    {
        return $this->getValue('team1');
    }

    /**
     * @return string
     */
    public function getTeam2() : string
    {
        return $this->getValue('team2');
    }

    /**
     * @return string
     */
    public function getMatchUrl() : string
    {
        return $this->getValue('url');
    }

    /**
     * @return string
     */
    public function getEvent() : string
    {
        return $this->getValue('event');
    }

    /**
     * @return int
     */
    public function getStatus() : int
    {
        return $this->getValue('status');
    }

    /**
     * @return int
     */
    public function getWinner() : int
    {
        return $this->getValue('winner');
    }

    /**
     * @return string
     */
    public function getTimestamp() : string
    {
        return $this->getValue('timestamp');
    }

    /**
     * @return Entity|MatchDetails
     * @throws \Exception
     */
    public function details() : MatchDetails
    {
        return $this->client->matchDetails($this->getMatchUrl());
    }
}