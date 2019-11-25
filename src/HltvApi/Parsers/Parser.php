<?php

namespace HltvApi\Parsers;


use HltvApi\Entity\Match;
use Sunra\PhpSimple\HtmlDomParser;

/**
 * Class Parser
 * @package HltvApi\Parsers
 */
abstract class Parser
{
    /**
     * @var array
     */
    protected $data;

    /**
     * Parser constructor.
     * @param string $data
     */
    public function __construct(string $data)
    {
        if(!$data) {
            $this->data = [];
            return;
        }
        // look for vendor/sunra/php-simple-html-dom-parser/Src/Sunra/PhpSimple/simplehtmldom_1_5/simple_html_dom.php
        // parser required global limit const
        if (!defined('MAX_FILE_SIZE'))
        {
            define('MAX_FILE_SIZE', 6000000);
        }
        $this->data = HtmlDomParser::str_get_html( $data );
    }

    /**
     * @return mixed
     */
    abstract public function parse();

    /**
     * @param string $data
     */
    public function setData(string $data) : void
    {
        $this->data = HtmlDomParser::str_get_html( $data );
    }

    /**
     * Internal hltv id using as unique int var per system
     *
     * @param $var
     * @return null
     */
    public function getId($var)
    {
        $attr = explode("/", $var);
        return isset($attr[2]) ? $attr[2] : null ;
    }

    /**
     * Return match type look for Match const
     *
     * @param $type
     * @return int|null
     */
    public function getType($type)
    {
        $lt = null;
        switch ($type) {
            case 'bo5':
                $lt = Match::TYPE_BO5;
                break;
            case 'bo3':
                $lt = Match::TYPE_BO3;
                break;
            case 'bo2':
                $lt = Match::TYPE_BO2;
                break;
            case 'bo1':
            case 'mrg':
            case 'trn':
            case 'nuke':
            case 'd2':
            case 'inf':
            case 'vtg':
            case 'ovp':
                $lt = Match::TYPE_BO1;
                break;
            default:
                $lt = Match::TYPE_UNDEFINED;
                break;
        }

        return $lt;
    }

}