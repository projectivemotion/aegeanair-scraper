<?php
/**
 * Project: AegeanScraper
 *
 * @author Amado Martinez <amado@projectivemotion.com>
 */
require_once 'vendor/autoload.php';

$scraper = new \projectivemotion\AegeanScraper\Scraper();

$postdata   =   ['lang' => '3',
'Referer' => 'eticket',
'ReturnUrl' => 'https://en.aegeanair.com/plan/book-a-flight/',
'AirportFrom' => 'AMS',
'AirportTo' => 'ATH',
'DateDeparture' => '28/01/2017',
'DateReturn' => '29/01/2017',
'TravelType' => 'R',
'AdultsNum' => '1',
'Children16Nums' => '0',
'Children12Nums' => '0',
'Children5Num' => '0',
'InfantsNum' => '0',
'Btn_DaysRange' => '3',
'directFlights' => 'indirect'];


$url = 'https://en.aegeanair.com/PostHandler.axd';


$G = new \GuzzleHttp\Client(['cookies' => true]);

$response1 = $G->post($url, [ 'form_params' => $postdata]);


$info = $scraper->getRedirectPostInfo($response1->getBody());

$url = $info['action'];
$postdata = $info['post'];

$response2 = $G->post($url, [ 'form_params' => $postdata]);

$info = $scraper->getApiParams($response2->getBody());

$url = $info['action'];
$postdata = $info['post'];

$response3 = $G->post($url, [ 'form_params' => $postdata]);

echo $response3->getBody();

