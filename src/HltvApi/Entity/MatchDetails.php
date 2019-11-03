<?php
namespace HltvApi\Entity;


/**
 * Class MatchDetails
 * @package HltvApi\Entity
 */
class MatchDetails extends Match
{
    public function getType()
    {
        return $this->getValue('type');
    }
}