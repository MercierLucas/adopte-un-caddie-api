<?php

require_once("Entities/Product.php");

class ProductModel
{
    var $table = "product";
    var $bdd;

    public function __construct()
    {
        $this->bdd = Database::GetDatabase();
    }

    private function createFromRows($data)
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
            return $this->createFromRows($result);
        }

        return null;
    }
}