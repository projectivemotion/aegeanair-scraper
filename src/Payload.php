<?php
/**
 * Project: AegeanScraper
 *
 * @author Amado Martinez <amado@projectivemotion.com>
 */

namespace projectivemotion\AegeanScraper;


class Payload
{
    protected $json;

    public function __construct($json)
    {
        $this->json=    $json;
    }


    public function __get($name)
    {
        return $this->json->$name;
    }

    public function getDictionary($dict, $key)
    {
        $value  =   $this->dictionaries->all->$dict->$key;
        return $value;
    }

    public function getLocation($key)
    {
        $location   =   $this->getDictionary('A3Location', $key);
        if(isset($location->parent) && is_string($location->parent)){
            $location->parent   =   $this->getLocation($location->parent);
        }
        return $location;
    }

    public function genPrice($bound, $flight_id)
    {
        foreach($bound->fareFamilies as $fareFamily){
            $farekey    =   "{$fareFamily}_{$flight_id}";
            if(!isset($bound->defaultDisplays->$farekey)) continue;
            // @todo add with tax without tax etc
            yield $fareFamily => $bound->defaultDisplays->$farekey->price->price->totalPrice->cashAmount;
        }
    }

    public function genFlights()
    {
        foreach($this->modelObject->availabilities->upsell->bounds as $bound){
            $origin = $this->getLocation($bound->searchDestination->originLocation);
            $destination = $this->getLocation($bound->searchDestination->destinationLocation);

            foreach($bound->flights as $flight){
                $segments   =   [];
                foreach($flight->segments as $segmentdata){
                    $segment    =   [
                        'operatingAirline'  =>  isset($segmentdata->operatingAirline) ? $this->getDictionary('A3Airline', $segmentdata->operatingAirline) : null,
                        'originLocation'    => $this->getLocation($segmentdata->originLocation)->parent->code,
                        'destinationLocation'    => $this->getLocation($segmentdata->destinationLocation)->parent->code,
                        'destinationDate'   =>  ($segmentdata->destinationDate/1000),
                        'duration'  =>  $segmentdata->duration/1000,
                        'equipment' =>  $this->getDictionary('A3Equipment', $segmentdata->equipment),
                        'flightIdentifier'  => $segmentdata->flightIdentifier
                    ];
                    $segment['code']    =   $segment['flightIdentifier']->marketingAirline . $segment['flightIdentifier']->flightNumber;
                    $segment['flightIdentifier']->originDate = ($segment['flightIdentifier']->originDate/1000);
                    unset($segment['flightIdentifier']->{'@class'});
                    $segments[$segment['code']] = (object)$segment;
                }
                $flight = (object)[
                    'origin'    => $origin->code,
                    'destination'   => $destination->code,
                    'price' => (object)iterator_to_array($this->genPrice($bound, $flight->id)),
                    'segments'  => $segments
                ];

                yield $flight;
            }

        }
    }
}