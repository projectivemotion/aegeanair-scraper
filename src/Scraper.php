<?php
/**
 * Project: AegeanScraper
 *
 * @author Amado Martinez <amado@projectivemotion.com>
 */

namespace projectivemotion\AegeanScraper;


class Scraper
{
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

        return $info;
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
        return $vars;
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