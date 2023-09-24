<?php 

        // connection details
        define('DB_HOST',"127.0.0.1");
        define('DB_NAME',"shop_db");
        define('DB_USER',"root");
        define('DB_PASS',"");

        try{
            $conn = new PDO('mysql:host=' . DB_HOST .';dbname=' . DB_NAME, DB_USER, DB_PASS);
            $conn->exec('SET NAMES utf8');
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            catch(PDOException $e){
            
            echo $e->getMessage();
            
            }
