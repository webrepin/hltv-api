<?php
namespace HltvApi\Entity;

use HltvApi\Client;
/**
 * Class Entity
 * @package HltvApi\Entity
 */
abstract class Entity
{
    /**
     * @var
     */
    protected $data;

    /**
     * @var Client
     */
    protected $client;

    /**
     * Entity constructor.
     * @param array $data
     * @param Client $client
     */
    public function __construct(array $data, Client $client)
    {
        $this->data = $data;
        $this->client;
    }

    /**
     * @return int
     */
    abstract public function getId() : int;

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param $name
     * @return null
     */
    protected function getValue($name)
    {
        return isset($this->data[$name])
            ? $this->data[$name]
            : null;
    }
}