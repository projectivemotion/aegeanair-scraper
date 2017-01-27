<?php
/**
 * Project: AegeanScraper
 *
 * @author Amado Martinez <amado@projectivemotion.com>
 */

namespace projectivemotion\AegeanScraper;


class Query
{
    const returnurl = 'https://en.aegeanair.com/plan/book-a-flight/';

    protected $origin;
    protected $destination;
    /**
     * @var \DateTime
     */
    protected $departure_date;

    /**
     * @var \DateTime
     */
    protected $return_date;
    protected $adults   =   1;
    protected $children511  =   0;
    protected $children24   =   0;
    protected $children02   =   0;

    public function getChildren02()
    {
        return $this->children02;
    }

    public function getChildren24()
    {
        return $this->children24;
    }

    public function getChildren511()
    {
        return $this->children511;
    }

    public function getReturnDate()
    {
        return $this->return_date;
    }

    public function getDepartureDate()
    {
        return $this->departure_date;
    }

    public function getDestination()
    {
        return $this->destination;
    }

    public function getOrigin()
    {
        return $this->origin;
    }

    public function getAdults()
    {
        return $this->adults;
    }

    public function setDestination($destination)
    {
        $this->destination = $destination;
    }

    public function setOrigin($origin)
    {
        $this->origin = $origin;
    }

    public function setDepartureDate(\DateTime $departure_date)
    {
        $this->departure_date = $departure_date;
    }

    public function setReturnDate(\DateTime $return_date)
    {
        $this->return_date = $return_date;
    }

    public function setAdults($adults)
    {
        $this->adults = $adults;
    }

    public function setChildren02($children02)
    {
        $this->children02 = $children02;
    }

    public function setChildren24($children24)
    {
        $this->children24 = $children24;
    }

    public function setChildren511($children511)
    {
        $this->children511 = $children511;
    }

    public function getPost()
    {
        if(!$this->getDepartureDate())
            throw new Exception();

        if(!$this->getDestination() || !$this->getOrigin())
            throw new Exception();

        $postdata   =   [
            'lang' => '3',
            'Referer' => 'eticket',
            'ReturnUrl' => self::returnurl,
            'AirportFrom' => $this->getOrigin(),
            'AirportTo' => $this->getDestination(),
            'DateDeparture' => $this->getDepartureDate()->format('d/m/Y'),
            'DateReturn' => $this->getReturnDate()->format('d/m/Y'),
            'TravelType' => 'R',
            'AdultsNum' => $this->getAdults(),
            'Children16Nums' => $this->getChildren511(),
            'Children12Nums' => $this->getChildren24(),
            'Children5Num' => $this->getChildren02(),
            'InfantsNum' => $this->getChildren02(),
            'Btn_DaysRange' => '3',
            'directFlights' => 'indirect'];

        return $postdata;
    }
}