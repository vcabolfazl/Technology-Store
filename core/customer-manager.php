<?php
    require_once("connection-manager.php");
    require_once("utilities.php");
    require_once("models/customer.php");

    class CustomerManager {

        protected $tableName = "customers";

        /**
         * add new record to customers tables
         * @param Customer $customer
         * @return bool|mysqli_result
         */
        public function add(Customer $customer) {

            $securePassword = getSecurePassword($customer->password);
            $lowerUsername = strtolower($customer->username);

            $fields = /** @lang text */
                "(full_name, username, password, phone, address)";
            $values = /** @lang text */
                "('$customer->fullName', '$lowerUsername', '$securePassword', '$customer->phone', '$customer->address')";
            $query = /** @lang text */
                "INSERT INTO $this->tableName $fields VALUES $values";

            $connectionManager = new ConnectionManager();         
            $result = mysqli_query($connectionManager->getConnection(), $query);
            $connectionManager->closeConnection();

            return $result;
        }

        /**
         * update the customer info
         * @param Customer $customer
         * @param $isNeedToHash
         * @return bool|mysqli_result
         */
        public function update(Customer $customer, $isNeedToHash) {

            if ($isNeedToHash) {
                $customer->password = getSecurePassword($customer->password);
            }

            $lowerUsername = strtolower($customer->username);

            $newValues = /** @lang text */
                "full_name = '$customer->fullName', username = '$lowerUsername', password = '$customer->password', phone = '$customer->phone', address = '$customer->address'";
            $query = /** @lang text */
                "UPDATE $this->tableName SET $newValues WHERE customer_id = $customer->customerId";

            $connectionManager = new ConnectionManager();         
            $result = mysqli_query($connectionManager->getConnection(), $query);
            $connectionManager->closeConnection();

            return $result;
        }

        /**
         * delete specified customer
         * @param $customerId
         * @return bool|mysqli_result
         */
        public function delete($customerId) {

            $query = /** @lang text */
                "DELETE FROM $this->tableName WHERE customer_id = $customerId";

            $connectionManager = new ConnectionManager();         
            $result = mysqli_query($connectionManager->getConnection(), $query);
            $connectionManager->closeConnection();

            return $result;
        }

        /**
         * get all customer 
         */
        public function getAll() {
            
            $query = /** @lang text */
                "SELECT * FROM $this->tableName";

            $connectionManager = new ConnectionManager();

            $result = mysqli_query($connectionManager->getConnection(), $query);
            $rows = [];

            while ($row = $result->fetch_assoc()) 
                $rows[] = $row;

            $connectionManager->closeConnection();

            return $rows;
        }

        /**
         * get the specified customer info
         * @param $customerId
         * @return Customer
         */
        public function getById($customerId) {

            $query = /** @lang text */
                "SELECT * FROM $this->tableName WHERE customer_id = $customerId";

            $connectionManager = new ConnectionManager();

            $result = mysqli_query($connectionManager->getConnection(), $query);

            $row = $result->fetch_assoc();
            $customer = new Customer();
            $customer->customerId = $row['customer_id'];
            $customer->fullName = $row['full_name'];
            $customer->username = $row['username'];
            $customer->password = $row['password'];
            $customer->phone = $row['phone'];
            $customer->address = $row['address'];

            $connectionManager->closeConnection();

            return $customer;
        }

        /**
         * get the specified customer info
         * @param $username
         * @return Customer
         */
        public function getByUsername($username) {

            $lowerUsername = strtolower($username);

            $query = /** @lang text */
                "SELECT * FROM $this->tableName WHERE username = '$lowerUsername'";

            $connectionManager = new ConnectionManager();
            $result = mysqli_query($connectionManager->getConnection(), $query);

            $row = $result->fetch_assoc();

            $customer = new Customer();
            $customer->customerId = $row['customer_id'];
            $customer->fullName = $row['full_name'];
            $customer->username = $row['username'];
            $customer->password = $row['password'];
            $customer->phone = $row['phone'];
            $customer->address = $row['address'];

            $connectionManager->closeConnection();

            return $customer;
        }

        /**
         * get the customers that captions contains the keyword
         * @param $keyword
         * @return array
         */
        public function search($keyword) {
            
            $query = /** @lang text */
                "SELECT * FROM ".$this->tableName." WHERE full_name LIKE '%".$keyword."%' OR username LIKE '%".$keyword."%'";

            $connectionManager = new ConnectionManager();

            $result = mysqli_query($connectionManager->getConnection(), $query);
            $rows = [];

            while ($row = $result->fetch_assoc()) 
                $rows[] = $row;

            $connectionManager->closeConnection();

            return $rows;
        }

        /**
         * check username and password for login
         * @param $username
         * @param $password
         * @return bool
         */
        public function login($username, $password) {

            if (empty($username) || empty($password))
                return false;

            $lowerUsername = strtolower($username);

            $query = /** @lang text */
                "SELECT * FROM ".$this->tableName." WHERE username = '$lowerUsername'";

            $connectionManager = new ConnectionManager();
            $selectedCustomer = mysqli_query($connectionManager->getConnection(), $query);
            $connectionManager->closeConnection();

            if (!$selectedCustomer) return false;

            $data = $selectedCustomer->fetch_assoc();
            return matchPasswords($password, $data['password']);
        }

        /**
         * check a username already registered or not
         * @param $username
         * @return bool
         */
        public function isExists($username) {

            $lowerUsername = strtolower($username);

            $query = /** @lang text */
                "SELECT username FROM ".$this->tableName." WHERE username = '$lowerUsername'";

            $connectionManager = new ConnectionManager();
            $selectedCustomer = mysqli_query($connectionManager->getConnection(), $query);
            $connectionManager->closeConnection();

            if ($selectedCustomer->num_rows > 0) 
                return true;
            else 
                return false;     
        }

        /**
         * check a username already registered or not [FOR EDIT]
         * @param $currentUsername
         * @param $selectedUsername
         * @return bool
         */
        public function isExistsForEdit($currentUsername, $selectedUsername) {

            $lowerCurrentUsername = strtolower($currentUsername);
            $lowerSelectedUsername = strtolower($selectedUsername);

            $query = /** @lang text */
                "SELECT username FROM ".$this->tableName." WHERE username = '$lowerCurrentUsername'";

            $connectionManager = new ConnectionManager();
            $selectedCustomer = mysqli_query($connectionManager->getConnection(), $query);
            $connectionManager->closeConnection();

            if ($selectedCustomer->num_rows < 1) 
                return false;

            if ($lowerCurrentUsername != $lowerSelectedUsername)
                return true; 

            return false;    
        }
    }

?>