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

2. Initialize Hltv-Api like this:
````php
require_once 'vendor/autoload.php';

use HltvApi\Client;

````

### Requests
|           Type               |                                    URL                                           |
|------------------------------|----------------------------------------------------------------------------------|
|        **Supported**         |                                                                                  |
| ongoing                      | https://www.hltv.org/matches                                                     |
| upcoming                     | https://www.hltv.org/matches                                                     |
| results                      | https://www.hltv.org/results                                                     |
| matchDetails                 | https://www.hltv.org/matches/xxxx-xxxx-xxxxx                                                 |
