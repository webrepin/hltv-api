<?php
namespace HltvApi;


/**
 * Class Proxy
 * @package HltvApi
 */
class Proxy
{
    /**
     * @var
     */
    protected $ip;
    /**
     * @var
     */
    protected $port;
    /**
     * @var
     */
    protected $type;

    /**
     * Proxy constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->ip = $data[0];
        $this->port = $data[1];
        $this->type = $data[2];
    }

    /**
     * @return mixed
     */
    public function ip()
    {
        return $this->ip;
    }

    /**
     * @return mixed
     */
    public function port()
    {
        return $this->port;
    }

    /**
     * @return mixed
     */
    public function type()
    {
        return $this->type;
    }
}