<?php
namespace HltvApi;

use HltvApi\Entity\Entity;
use HltvApi\Entity\Match;
use HltvApi\Entity\MatchDetails;
use HltvApi\Interfaces\Request;
use HltvApi\Parsers\MatchDetailsParser;
use HltvApi\Parsers\OngoingParser;
use HltvApi\Parsers\Parser;
use HltvApi\Parsers\ResultsParser;
use HltvApi\Parsers\UpcomingParser;
use HltvApi\Wrappers\BaseWrapper;

/**
 * Class Client
 * @package HltvApi
 */
class Client implements Request
{
    /**
     * Hltv WebAPI base URL
     */
    const BASE_URL = 'https://hltv.org';

    /**
     * Array for proxy list (optional)
     * [
     *  ['0.0.0.0', '80', CURLPROXY_SOCKS5],
     *  ['0.0.0.0', '8080', CURLPROXY_SOCKS5],
     * ]
     * @var array
     */
    protected $proxyList;

    /**
     * @var string
     */
    protected $baseUrl;

    /**
     * Client constructor.
     * @param array $proxy
     * @param $baseUrl
     */
    public function __construct(array $proxy = [], $baseUrl = null)
    {
        $this->proxyList = $proxy;
        $this->baseUrl = $baseUrl ?? self::BASE_URL;
    }

    /**
     * @return string
     */
    public function getUrlMatches() : string
    {
        return $this->baseUrl . '/matches';
    }

    /**
     * @return string
     */
    public function getUrlResults() : string
    {
        return $this->baseUrl . '/results';
    }

    /**
     * @param $link
     * @return string
     */
    public function getUrlDetails($link) : string
    {
        return $this->baseUrl . $link;
    }

    /**
     * @return Proxy|null
     */
    public function createProxy()
    {
        if(!count($this->proxyList)) {
            return null;
        }
        $idx = count($this->proxyList) - 1;
        $idx = rand(0, $idx);
        return new Proxy($this->proxyList[$idx]);
    }

    /**
     * @param null $url
     * @param string $method
     * @return string
     */
    public function sendRequest($url = null, $method = 'GET') : string
    {
        if( $ch = curl_init ())
        {
            $proxy = $this->createProxy();
            curl_setopt ($ch, CURLOPT_URL, $url);
            curl_setopt ($ch, CURLOPT_TIMEOUT, 60);
            if($proxy) {
                curl_setopt ($ch, CURLOPT_PROXY, "{$proxy->ip()}:{$proxy->port()}");
                curl_setopt ($ch, CURLOPT_PROXYTYPE, $proxy->type());
            }
            curl_setopt ($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt ($ch, CURLOPT_FAILONERROR, true);
            curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
            $result = curl_exec($ch);
            curl_close ($ch);
        }
        if(!$result && is_array($this->proxyList) && count($this->proxyList)) {
            return $this->sendRequest($url, $method);
        }
        return $result;
    }

    /**
     * Making a Parser object of same type whom implements parse method
     * @param string $type
     * @param string $url
     * @return Parser
     * @throws \Exception
     */
    public function createDataParser(string $type, string $url) : Parser
    {
        if (!class_exists($type)) {
            throw new \Exception('The requested type of parser is not exists');
        }
        if (!is_subclass_of($type , Parser::class)) {
            throw new \Exception('The requested parser should be children of Parser::class');
        }

        return (new $type($this->sendRequest($url)));
    }

    /**
     * Getting an ongoing list of Match objects
     * @return Match[]|array|null
     * @throws \Exception
     */
    public function ongoing() : array
    {
        $parser = $this->createDataParser(OngoingParser::class, $this->getUrlMatches());
        return (new BaseWrapper(Match::class, $parser->parse(), $this))->fetchList();
    }

    /**
     * Getting an upcoming list of Match-objects for x days at the scheduler
     *
     * @param int $days
     * @return Match[]|array|null
     * @throws \Exception
     */
    public function upcoming($days = 2) : array
    {
        /** @var UpcomingParser $parser */
        $parser = $this->createDataParser(UpcomingParser::class, $this->getUrlMatches());
        $parser->setDays($days);
        return (new BaseWrapper(Match::class, $parser->parse(), $this))->fetchList();
    }

    /**
     * Getting a result list of Match-objects
     *
     * @param int $days
     * @return Match[]|array|null
     * @throws \Exception
     */
    public function results() : array
    {
        $parser = $this->createDataParser(ResultsParser::class, $this->getUrlResults());
        return (new BaseWrapper(Match::class, $parser->parse(), $this))->fetchList();
    }

    /**
     * @param $link
     * @return MatchDetails
     * @throws \Exception
     */
    public function matchDetails($link) : Entity
    {
        $parser = $this->createDataParser(MatchDetailsParser::class, $this->getUrlDetails($link));
        return (new BaseWrapper(MatchDetails::class, $parser->parse(), $this))->fetchRow();
    }


}