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

    protected $details;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->getValue('id');
    }

    /**
     * @return string
     */
    public function getTeam1()
    {
        return $this->getValue('team1');
    }

    /**
     * @return string
     */
    public function getTeam2()
    {
        return $this->getValue('team2');
    }

    /**
     * @return string
     */
    public function getMatchUrl()
    {
        return $this->getValue('url');
    }

    /**
     * @return string
     */
    public function getEvent()
    {
        return $this->getValue('event');
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->getValue('status');
    }

    /**
     * @return int
     */
    public function getWinner()
    {
        return $this->getValue('winner');
    }

    /**
     * @return array
     */
    public function getResult()
    {
        return $this->getValue('result');
    }

    /**
     * @return string
     */
    public function getTimestamp()
    {
        return $this->getValue('timestamp');
    }

    /**
     * @return Entity|MatchDetails
     * @throws \Exception
     */
    public function details() : MatchDetails
    {
        return $this->details ?? $this->details = $this->client->matchDetails($this->getMatchUrl());
    }
}