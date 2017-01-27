# Aegean-Scraper
Aegean Airline Flights Price Scraper
[![Build Status](https://travis-ci.org/projectivemotion/aegean-scraper.svg?branch=master)](https://travis-ci.org/projectivemotion/aegean-scraper)

Last Verified: 2017-01-26

## Use at your own risk!
* I am not responsible for your use of this software.
* Please do not abuse!
* Check out my other projects: [Transavia-Scraper](https://github.com/projectivemotion/transavia-scraper), [Wizzair-Scraper](https://github.com/projectivemotion/wizzair-scraper), [Hotelscom-Scraper](https://github.com/projectivemotion/hotelscom-scraper), [EasyJet-Scraper](https://github.com/projectivemotion/easyjet-scraper), [Planitour-Scraper](https://github.com/projectivemotion/planitour-scraper), [Xgbs-Soap Client](https://github.com/projectivemotion/xgbs-soap)

### Manual Installation
    git clone https://github.com/projectivemotion/aegean-scraper.git
    cd aegean-scraper && composer update
    
### Composer Installation
    composer require projectivemotion/aegean-scraper
    
### Requirements
    PHP 5.6

### Usage

See `demo/` directory. for an example

Usage: demo/aegean.php AMS ATH 2017-03-26 2017-03-30
```
$ demo/aegean.php AMS ATH 2017-01-28 2017-01-29
[
    {
        "origin": "AMS",
        "destination": "ATH",
        "price": {
            "FLEXTEST": {
                "@class": "A3CashAmount",
                "amount": 172.53,
                "currency": "EUR"
            },
            "BUSINESTES": {
                "@class": "A3CashAmount",
                "amount": 661.53,
                "currency": "EUR"
            },
            "LIGHT": {
                "@class": "A3CashAmount",
                "amount": 132.53,
                "currency": "EUR"
            }
        },
        "segments": {
            "A3617": {
                "operatingAirline": null,
                "originLocation": "AMS",
                "destinationLocation": "ATH",
                "destinationDate": false,
                "duration": 11400,
                "equipment": {
                    "@class": "A3Equipment",
                    "dictionaryKey": "320",
                    "code": "320",
                    "name": "Airbus Industrie A320"
                },
                "flightIdentifier": {
                    "marketingAirline": "A3",
                    "flightNumber": "617",
                    "originDate": false
                }
            }
        }
    },
    {
        "origin": "AMS",
        "destination": "ATH",
        "price": {
            "FLEXTEST": {
                "@class": "A3CashAmount",
                "amount": 185.91,
                "currency": "EUR"
            },
            "BUSINESTES": {
                "@class": "A3CashAmount",
                "amount": 482.91,
                "currency": "EUR"
            }
        },
        "segments": {
            "A3617": {
                "operatingAirline": null,
                "originLocation": "AMS",
                "destinationLocation": "ATH",
                "destinationDate": false,
                "duration": 11400,
                "equipment": {
                    "@class": "A3Equipment",
                    "dictionaryKey": "320",
                    "code": "320",
                    "name": "Airbus Industrie A320"
                },
                "flightIdentifier": {
                    "marketingAirline": "A3",
                    "flightNumber": "617",
                    "originDate": false
                }
            },
            "A31403": {
                "operatingAirline": {
                    "@class": "A3Airline",
                    "dictionaryKey": "LH",
                    "code": "LH",
                    "name": "Lufthansa"
                },
                "originLocation": "AMS",
                "destinationLocation": "FRA",
                "destinationDate": false,
                "duration": 3900,
                "equipment": {
                    "@class": "A3Equipment",
                    "dictionaryKey": "320",
                    "code": "320",
                    "name": "Airbus Industrie A320"
                },
                "flightIdentifier": {
                    "marketingAirline": "A3",
                    "flightNumber": "1403",
                    "originDate": false
                }
            },
            "A31830": {..
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
