<?php


class Product
{
    var $name;
    var $description;

    public function __construct($object)
    {
        $this->name = $object["name"];
        $this->description = $object["description"];
    }
}