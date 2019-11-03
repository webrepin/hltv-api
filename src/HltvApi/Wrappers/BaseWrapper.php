<?php
namespace HltvApi\Wrappers;

use HltvApi\Entity\Entity;
/**
 * Class BaseWrapper
 * @package HltvApi\Wrappers
 */
class BaseWrapper extends Wrapper
{
    /**
     * @return array
     */
    public function fetchList() : array
    {
        if(!is_array($this->data) || !count($this->data)) {
            return [];
        }
        $result = [];
        $class = $this->entityType;
        foreach ($this->data as $row) {
            $result[] = new $class($row, $this->client);
        }
        return $result;
    }

    /**
     * @return Entity
     */
    public function fetchRow() : Entity
    {
        $class = $this->entityType;
        return new $class($this->data, $this->client);
    }
}