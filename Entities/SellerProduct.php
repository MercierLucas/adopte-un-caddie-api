<?php

class SellerProduct
{
    var $price;
    var $quantity;
    var $sellerName;

    public function __construct($object)
    {
        $this->price = $object["price"];
        $this->quantity = $object["quantity"];
        $this->sellerName = $object["name"];
    }
}