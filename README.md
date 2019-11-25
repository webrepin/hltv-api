# PHP hltv-api
The hltv based module for the automatic event grabbing

### About

1. **What is it?**
This is PHP code for parsing Hltv requests.

2. **What can it do?**
It can get actual match-list, get detailed match-info for single match.

3. **What I need to work with it?**
First of all you need web-server with **PHP 7.0+** ( **PDO** and **cURL** should be enabled). Then look at install section.

### Install

1. Install via [Composer](http://getcomposer.org/):

    ````json
    {
        "require": {
            "webrepin/hltv-api": "*"
        }
    }
    ````

2.  Initialize Hltv-Api like this:

    ````php
    require_once 'vendor/autoload.php';
    
    use HltvApi\Client;
    
    $client = new Client();
    
    ````
3. Supported list of requests is:

    ### Requests
    |           Type               |                                    URL                                           |
    |------------------------------|----------------------------------------------------------------------------------|
    |        **Supported**         |                                                                                  |
    | ongoing                      | https://www.hltv.org/matches                                                     |
    | upcoming                     | https://www.hltv.org/matches                                                     |
    | results                      | https://www.hltv.org/results                                                     |
    | matchDetails                 | https://www.hltv.org/matches/xxxx-xxxx-xxxxx                                     |

4. All request return object abstract layer based on Entity 

    ````php
    use HltvApi\Entity\Entity;
    ````
    
    Example how to getting ongoing match list: 
    
    ````php
    require_once 'vendor/autoload.php';
        
    use HltvApi\Client;
   
    $client = new Client();
 
    $matches = $client->ongoing();
 
    foreach ($matches as $match) {
       echo $match->getTeam1();
       echo $match->getTeam2();
       echo $match->getMatchUrl();
       echo $match->getMatchUrl();
    }
    ````
    
    Follow the match details:
    
    ````php
    echo $match->details()->getOdds()
    echo $match->details()->getMapName(1)
    echo $match->details()->getMapScore(1)
    echo $match->details()->getMapResults(1)
    ````
    
5. To getting more stability you can protect your request  by using Proxy list
  
    ````php
    require_once 'vendor/autoload.php';
        
    use HltvApi\Client;
   
    $client = new Client([
       ['0.0.0.0', '80', CURLPROXY_SOCKS5],
       ['0.0.0.0', '443', CURLPROXY_HTTP],
       ...
    ]);
 
    
     ````