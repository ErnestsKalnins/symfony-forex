<?php

namespace App\Service;

class LatviaBankForexService
{
    protected $xml;
    protected $rates;

    public function __construct($path)
    {
        $this->xml = simplexml_load_file(
            $path,
            'SimpleXMLElement',
            LIBXML_NOCDATA
        );
    }

    public function getForexRates()
    {
        return empty($this->rates)
            ? $this->rates = $this->parseEntries()
            : $this->rates;
    }

    private function parseEntries()
    {
        $rates = [];
        foreach ($this->xml->children()->children()->item as $entry) {
            $rates = array_merge($rates, $this->parseEntry($entry));
        }
        return $rates;
    }

    private function parseEntry($entry)
    {
        $entryRates = [];
        $rate = [];

        $tokens = $this->tokenize($entry);
        $date = $this->parseDate($entry);

        foreach ($tokens as $token) {
            if ($this->isCurrencyToken($token)) {
                $rate['currency'] = $token;
            } else if ($this->isRateToken($token)) {
                $rate['rate'] = floatval($token);
                $rate['published_at'] = $date;
                array_push($entryRates, $rate);
                $rate = [];
            }
        }
        return $entryRates;
    }

    private function tokenize($entry)
    {
        return array_filter(explode(' ', strval($entry->description)));
    }

    private function parseDate($entry)
    {
        $date = new \DateTime(strval($entry->pubDate));
        $date->setTimeZone(new \DateTimeZone('UTC'));
        return $date;
    }

    private function isCurrencyToken($token) {
        return preg_match('/[A-Z]{3}/', $token);
    }

    private function isRateToken($token) {
        return preg_match('/([0-9]*[.])?[0-9]+/', $token);
    }
}