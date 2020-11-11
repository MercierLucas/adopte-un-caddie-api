<?php

require_once("Entities/Product.php");
require_once("Models/ProductModel.php");

class ProductController
{
    var $productModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
    }

    public function handle($action,$param)
    {
        switch($action)
        {
            default:
                ResponseSerializer::RaiseError("Action not recognized");
                break;

            case "getBy":
                $this->getBy($param);
                break;
        }
    }

    public function getBy($param)
    {
        $intParam = intval($param);
        if($intParam != 0)
        {
            $this->getByID($intParam);
        }
        else
        {
            $this->getByName($param);
        }
    }

    public function getByID($param)
    {
        $product = $this->productModel->getByID($param);

        if($product != null)
        {
            ResponseSerializer::Send($product);
        }
        else
        {
            ResponseSerializer::RaiseError("Product not found");
        }

    }

    public function getByName($param)
    {
        $products = $this->productModel->getByName($param);

        if($products != null)
        {
            ResponseSerializer::Send($products);
        }
        else
        {
            ResponseSerializer::RaiseError("Product not found");
        }
    }
}