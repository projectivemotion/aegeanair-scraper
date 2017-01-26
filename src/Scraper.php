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