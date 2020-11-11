<?php

class ShopModel
{
    var $table = "shop";
    var $bdd;

    public function __construct()
    {
        $this->bdd = Database::GetDatabase();
    }

    private function createShopsListFromRows($data)
    {
        $shops = array();

        for($i = 0; $i< sizeof($data);$i++)
        {
            array_push($shops,new Shop($data[$i]));
        }

        return $shops;
    }

    public function getByCompanyID($id)
    {
        $sql = "select * FROM {$this->table} WHERE company_UID = {$id}";
        $ans=$this->bdd->query($sql);
        $result = $ans->fetchall(PDO::FETCH_ASSOC);

        if(sizeof($result) > 0)
        {
            return $this->createShopsListFromRows($result);
        }

        return null;
    }

    public function getByCompanyName($name)
    {
        $sql = "select shop.name,shop.longitude,shop.latitude,shop.adress
                FROM shop 
                join company on shop.company_UID = company.uid
                where company.name like \"%{$name}%\"";

        $ans=$this->bdd->query($sql);
        $result = $ans->fetchall(PDO::FETCH_ASSOC);

        if(sizeof($result) > 0)
        {
            return $this->createShopsListFromRows($result);
        }

        return null;
    }

    public function getClosest($param)
    {
        // most of this comes from : https://www.movable-type.co.uk/scripts/latlong-db.html
        // user's position
        $lat = 48.827311;
        $lon = 2.277090;
        $rad = $param; // in km

        $R = 6371; // radius of the earth

        $maxLat = $lat + rad2deg($rad/$R);
        $minLat = $lat - rad2deg($rad/$R);
        $maxLon = $lon + rad2deg(asin($rad/$R) / cos(deg2rad($lat)));
        $minLon = $lon - rad2deg(asin($rad/$R) / cos(deg2rad($lat)));

        $lat = deg2rad($lat);
        $lon = deg2rad($lon);

        $sql = "Select uid, name, latitude, longitude,adress,
                acos(sin({$lat})*sin(radians(latitude)) + cos({$lat})*cos(radians(latitude))*cos(radians(longitude)-{$lon})) * {$R} As D
                From (
                    Select uid, name, latitude, longitude,adress
                    From shop
                    Where latitude Between {$minLat} And {$maxLat}
                    And longitude Between {$minLon} And {$maxLon}
                ) As FirstCut
                Where acos(sin({$lat})*sin(radians(latitude)) + cos({$lat})*cos(radians(latitude))*cos(radians(longitude)-{$lon})) * {$R} < {$rad}
                Order by D";

        $ans=$this->bdd->query($sql);
        $result = $ans->fetchall(PDO::FETCH_ASSOC);


        if(sizeof($result) > 0)
        {
            return $this->createShopsListFromRows($result);
        }

        return null;
    }

}