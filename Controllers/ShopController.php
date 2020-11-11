<?php

// entities
require_once("Entities/Shop.php");
require_once("Entities/Company.php");

// model
require_once("Models/ShopModel.php");

class ShopController
{
    var $shopModel;

    public function __construct()
    {
        $this->shopModel = new ShopModel();
    }

    public function handle($action,$param)
    {
        switch($action)
        {
            default:
                ResponseSerializer::RaiseError("Action not recognized");
                break;

            case "getAllByCompany":
                $this->getAllByCompany($param);
                break;

            case "getClosest":
                $this->getClosest($param);
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

    private function getClosest($param)
    {
        $intParam = intval($param);
        $shops = $this->shopModel->getClosest($intParam);

        $this->send($shops);
    }

    public function getAllByCompany($param)
    {
        $intParam = intval($param);
        if($intParam != 0)
        {
            $this->getAllByCompanyID($intParam);
        }
        else
        {
            $this->getAllByCompanyName($param);
        }
    }

    public function getAllByCompanyID($param)
    {
        $shops = $this->shopModel->getByCompanyID($param);

        $this->send($shops);

    }

    public function getAllByCompanyName($param)
    {
        $shops = $this->shopModel->getByCompanyName($param);

        $this->send($shops);
    }
}