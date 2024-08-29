<?php

namespace SteamApi\Entity;


class ProcessXmlFormat
{
    private $data;

    /** Constructor. */
    public function __construct($data) {
        $this->data = $data;
    }

    public function process()
    {
        $games = new SimpleXMLElement($this->data);
        foreach ($games as $game) {

        }
    }
}