<?php

class Shop
{
    var $name;
    var $lat;
    var $long;
    var $adress;
    var $currentDistance;

    public function __construct($object)
    {
        $this->name = $object["name"];
        $this->lat = $object["latitude"];
        $this->long = $object["longitude"];
        $this->adress = $object["adress"];

        $this->currentDistance = array_key_exists("D",$object) ? $object["D"] : "Unknown";

    }
}