<?php 

    class ConnectionManager {

        // connection details
        private const HOST = "127.0.0.1";
        private const DATABASE = "shop_db";
        private const USERNAME = "root";
        private const PASSWORD = "";
        
        private $connection;

        public function __construct() {
            $this->connection = new mysqli(self::HOST, self::USERNAME, self::PASSWORD, self::DATABASE);
            $this->connection->set_charset("utf8");
        }
        
        public function getConnection() { 
            return $this->connection;        
        }

        public function closeConnection() {
            $this->connection->close();
        }
    }

?>