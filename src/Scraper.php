<?php
/**
 * Project: AegeanScraper
 *
 * @author Amado Martinez <amado@projectivemotion.com>
 */

namespace projectivemotion\AegeanScraper;


use GuzzleHttp\Client;

class Scraper
{
    /**
     * @var Client
     */
    protected $client;

    protected $options  =   [];


    public function __construct($options    =   [])
    {
        $this->options  =   [
                'cookies' => true
            ] + $options;
    }

    public function getClient()
    {
        if(!$this->client){
            $this->setClient(new Client($this->options));
        }
        return $this->client;
    }

    public function setClient($client)
    {
        $this->client = $client;
    }

    public function api($url, $post = null)
    {
        if(is_object($url))
        {
            $post   =   $url->post;
            $url    =   $url->action;
        }

        return $this->getClient()->post($url, $post ? ['form_params' => $post] : null);
    }

    public function getFlights(Query $q)
    {
        $response1 = $this->api('https://en.aegeanair.com/PostHandler.axd', $q->getPost());
        $params = $this->getRedirectPostInfo($response1->getBody());
        $response2 = $this->api($params);

        $params   =   $this->getApiParams($response2->getBody());
        $flightdata =   $this->api($params);

        $flights    =   $this->parseJsonPayload(\json_decode($flightdata->getBody()));

        return iterator_to_array($flights);
    }

    public function getRedirectPostInfo($body)
    {
        $info = ['action' => '', 'post' => []];

        $doc = $this->getDoc($body);
        $xpath  =   new \DOMXPath($doc);

        $form_el    =   $xpath->query('//form[@id="form_MasterPage"]');
        if(!$form_el || $form_el->length != 1)
            throw new Exception("Did not find form_MasterPage");

        $inputs =   $xpath->query('.//input', $form_el[0]);
        if(!$inputs)
            throw new Exception();

        foreach($inputs as $input)
        {
            $info['post'][$input->getAttribute('name')] = $input->getAttribute('value');
        }

        $info['action'] =   $form_el[0]->getAttribute('action');

        return (object)$info;
    }

    public function getApiParams($body)
    {
        // quick and dirty javascript var extraction
        $count = preg_match_all('#var ([^=; ]*?)\s*=\s*([\s\S]*?)\n#', $body, $matches, PREG_SET_ORDER);
        $vars = [];
        foreach($matches as list($expr, $var, $value)){
            $value = preg_replace_callback('/\\\\u([0-9a-fA-F]{4})/', function ($match) {
                return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
            }, trim($value, "\r\n;"));
            $json = \json_decode('[' . preg_replace("#'(.*?)'#", '"\1"', $value) . ']');
            if(!$json) continue;
            $vars[$var] = $json[0];
        }

        $params = [
            'action' =>sprintf("https://e-ticket.aegeanair.com/A3Responsive/dyn/air/booking/%s.json;jsessionid=%s",
                $vars['firstBeCallTargetName'], $vars['jsessionid']),
            'post'  => [
                "dataType:json" => "",
                'FORCE_OVERRIDE' => $vars['entryRequestParams']->FORCE_OVERRIDE ? "TRUE" : "FALSE",
                'LANGUAGE' => $vars['entryRequestParams']->LANGUAGE,
                'SITE' => $vars['entryRequestParams']->SITE,
                'SKIN' => $vars['entryRequestParams']->SKIN,
                'data' => \json_encode($vars['entryRequestParams'])
            ],
            'js'    => $vars
        ];

        return (object)$params;
    }

    public function parseJsonPayload($jsonobj)
    {
        $bom = isset($jsonobj->bom) ? \json_decode($jsonobj->bom) : null;
        if(!$bom || !$bom->modelObject || !$bom->modelObject->availabilities
            || !$bom->modelObject->availabilities->upsell)
            throw new Exception('json error');

        $payload = new Payload($bom);

        return $payload->genFlights();
    }
    /**
     * @param $body
     * @return \DOMDocument
     */
    public function getDoc($body)
    {
        libxml_use_internal_errors(true);
        $dom = new \DOMDocument();
        $dom->loadHTML('<?xml encoding="utf-8" ?>' . $body);
        libxml_clear_errors();
        return $dom;
    }
}