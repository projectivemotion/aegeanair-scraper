<?php
/**
 * Project: AegeanScraper
 *
 * @author Amado Martinez <amado@projectivemotion.com>
 */
if(!isset($argv))
    die("Run from command line.");

// copied this from doctrine's bin/doctrine.php
$autoload_files = array( __DIR__ . '/../vendor/autoload.php',
    __DIR__ . '/../../../autoload.php');

foreach($autoload_files as $autoload_file)
{
    if(!file_exists($autoload_file)) continue;
    require_once $autoload_file;
}
// end autoloader finder


if($argc < 5)
    die("Usage:\n\t$argv[0] origin destination outbound-date inbound-date\n" .
        "Example:\n\t$argv[0] AMS ATH 2017-11-21 2017-11-25\n\n");


$origin = $argv[1];
$destination = $argv[2];
$departure_date_str = $argv[3];
$return_date_str = $argv[4];

$Scraper    =   new \projectivemotion\AegeanScraper\Scraper();
$Q = new \projectivemotion\AegeanScraper\Query();

$Q->setDestination($destination);
$Q->setOrigin($origin);
$Q->setDepartureDate(date_create_from_format('Y-m-d', $departure_date_str));
$Q->setReturnDate(date_create_from_format('Y-m-d', $return_date_str));

$flights = $Scraper->getFlights($Q);

echo \json_encode($flights, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);