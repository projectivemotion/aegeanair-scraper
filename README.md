# Aegean-Scraper
Aegean Airline Flights Price Scraper
[![Build Status](https://travis-ci.org/projectivemotion/aegean-scraper.svg?branch=master)](https://travis-ci.org/projectivemotion/aegean-scraper)

Last Verified: 2017-02-04

## Use at your own risk!
* I am not responsible for your use of this software.
* Please do not abuse!
* Check out my other projects: [Blueair-Scraper](https://github.com/projectivemotion/blueair-scraper), [Transavia-Scraper](https://github.com/projectivemotion/transavia-scraper), [Wizzair-Scraper](https://github.com/projectivemotion/wizzair-scraper), [Hotelscom-Scraper](https://github.com/projectivemotion/hotelscom-scraper), [EasyJet-Scraper](https://github.com/projectivemotion/easyjet-scraper), [Planitour-Scraper](https://github.com/projectivemotion/planitour-scraper), [Xgbs-Soap Client](https://github.com/projectivemotion/xgbs-soap)

### Manual Installation
    git clone https://github.com/projectivemotion/aegean-scraper.git
    cd aegean-scraper && composer install --no-dev
    
### Composer Installation
    composer require projectivemotion/aegean-scraper
    
### Requirements
    PHP 5.6

### Usage

See `demo/` directory. for an example

Usage: demo/aegean.php AMS ATH 2017-03-26 2017-03-30
```
/tmp/tmp.iWjNnzYD9K/aegean-scraper $ php -f demo/aegean.php ATH PRG $(date -d 'next month' +%Y-%m-25) $(date -d 'next month' +%Y-%m-27) --table
from    |to      |    flex|business|   light|flights         
ATH     |PRG     |2017-03-25T09:15:00+00:00|158.89 EUR|382.89 EUR|123.89 EUR|A3864           
PRG     |ATH     |2017-03-27T15:45:00+00:00|150.66 EUR|374.66 EUR|115.66 EUR|A3865
```

# License
The MIT License (MIT)

Copyright (c) 2017 Amado Martinez

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
