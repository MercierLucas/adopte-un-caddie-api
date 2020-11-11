<?php

    class Database 
    {
        private static $bdd = null;

        public static function GetDatabase()
        {
            if(is_null(self::$bdd))
            {
                try {
                    self::$bdd = new PDO('mysql:host=localhost;dbname=adopte_un_caddie', 'root', '');
                } catch (PDOException $e) {
                    print "Erreur !: " . $e->getMessage() . "<br/>";
                    die();
                }
            }
            return self::$bdd;
        }
    }