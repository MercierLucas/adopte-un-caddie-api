<?php

// entities
require_once("Entities/Product.php");
require_once("Entities/SellerProduct.php");

// model
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

            case "getSellers":
                $this->compare($param);
                break;
        }
    }

    private function send($obj)
    {
        if($obj != null)
        {
            ResponseSerializer::Send($obj);
        }
        else
        {
            ResponseSerializer::RaiseError("Sellers not found not found");
        }
    }

    public function compare($param)
    {
        $intParam = intval($param);
        $products = $this->productModel->getSellers($intParam);

        $this->send($products);
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

        $this->send($product);

    }

    public function getByName($param)
    {
        $products = $this->productModel->getByName($param);

        $this->send($products);
    }
}