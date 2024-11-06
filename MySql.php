<?php
    class MySql{
        private static $pdo;

        //conexão estatica com banco de dados
        public  static function getConn()
        {
            if(self::$pdo == null){
                self::$pdo = new PDO('mysql:host=localhost;dbname=e-commerce', 'root', '');
                return self::$pdo;
            }else{
                return self::$pdo;
            }
        }

    }