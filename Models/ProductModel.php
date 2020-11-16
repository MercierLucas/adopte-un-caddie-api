<?php

require_once("Entities/Product.php");
require_once("Entities/SellerProduct.php");

class ProductModel
{
    var $table = "product";
    var $bdd;

    public function __construct()
    {
        $this->bdd = Database::GetDatabase();
    }

    private function createSellerProductsFromRows($data)
    {
        $sellerProducts = array();

        for($i = 0; $i< sizeof($data);$i++)
        {
            array_push($sellerProducts,new SellerProduct($data[$i]));
        }
        
        return $sellerProducts;
    }

    private function createProductsFromRows($data)
    {
        $products = array();

        for($i = 0; $i< sizeof($data);$i++)
        {
            array_push($products,new Product($data[$i]));
        }
        
        return $products;
    }

    public function getByID($id)
    {
        $sql = "select * FROM {$this->table} WHERE product.uid = {$id}";
        $ans=$this->bdd->query($sql);
        $result = $ans->fetchall(PDO::FETCH_ASSOC);

        if(sizeof($result) > 0)
        {
            return new Product($result[0]);
        }

        return null;
    }

    public function getByName($name)
    {
        $sql = "select * FROM {$this->table} WHERE product.name like \"%{$name}%\"";
        $ans=$this->bdd->query($sql);
        $result = $ans->fetchall(PDO::FETCH_ASSOC);

        if(sizeof($result) > 0)
        {
            return $this->createProductsFromRows($result);
        }

        return null;
    }

    public function getSellers($productID)
    {
        $sql = "select product_shop_xref.price,product_shop_xref.quantity,shop.name FROM 
                product join product_shop_xref on product.uid = product_shop_xref.product_uid
                join shop on shop.uid = product_shop_xref.shop_uid
                where product.uid = {$productID}";

        //echo $sql;
        $ans=$this->bdd->query($sql);
        $result = $ans->fetchall(PDO::FETCH_ASSOC);

        if(sizeof($result) > 0)
        {
            return $this->createSellerProductsFromRows($result);
        }

        return null;
    }
}