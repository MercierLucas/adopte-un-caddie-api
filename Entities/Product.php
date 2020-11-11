<?php


class Product
{
    var $name;

    public function __construct($object)
    {
        $this->name = $object["name"];
    }
}