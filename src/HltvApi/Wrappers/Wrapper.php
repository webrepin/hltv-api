<?php
namespace HltvApi\Wrappers;

use HltvApi\Client;
/**
 * Class Wrapper
 * @package HltvApi\Wrappers
 */
abstract class Wrapper
{
    /**
     * @var string
     */
    protected $entityType;

    /**
     * @var Client
     */
    protected $client;
    /**
     * @var string
     */
    protected $data;

    /**
     * Wrapper constructor.
     * @param string $entityType
     * @param array $data
     * @param Client $client
     */
    public function __construct(string  $entityType, array $data, Client $client )
    {
        $this->entityType = $entityType;
        $this->data = $data;
        $this->client = $client;
    }

    /**
     * @param string $type
     */
    public function setEntityType(string $type)
    {
        $this->entityType = $type;
    }

    /**
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }
}