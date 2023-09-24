<?php
    require_once("connection-manager.php");
    require_once("utilities.php");
    require_once("models/user.php");

    class UserManager {

        protected $tableName = "users";

        /**
         * add new record to users tables
         * @param User $user
         * @return bool|mysqli_result
         */
        public function add(User $user) {

            $securePassword = getSecurePassword($user->password);
            $lowerUsername = strtolower($user->username);

            $fields = /** @lang text */
                "(full_name, username, password)";
            $values = /** @lang text */
                "('$user->fullName', '$lowerUsername', '$securePassword')";
            $query = /** @lang text */
                "INSERT INTO $this->tableName $fields VALUES $values";

            $connectionManager = new ConnectionManager();         
            $result = mysqli_query($connectionManager->getConnection(), $query);
            $connectionManager->closeConnection();

            return $result;
        }

        /**
         * update the user info
         * @param User $user
         * @param $isNeedToHash
         * @return bool|mysqli_result
         */
        public function update(User $user, $isNeedToHash) {

            if ($isNeedToHash) {
                $user->password = getSecurePassword($user->password);
            }

            $lowerUsername = strtolower($user->username);

            $newValues = "full_name = '$user->fullName', username = '$lowerUsername', password = '$user->password'";
            $query = /** @lang text */
                "UPDATE $this->tableName SET $newValues WHERE user_id = $user->userId";

            $connectionManager = new ConnectionManager();         
            $result = mysqli_query($connectionManager->getConnection(), $query);
            $connectionManager->closeConnection();

            return $result;
        }

        /**
         * delete specified user
         * @param $userId
         * @return bool|mysqli_result
         */
        public function delete($userId) {

            $query = /** @lang text */
                "DELETE FROM $this->tableName WHERE user_id = $userId";

            $connectionManager = new ConnectionManager();         
            $result = mysqli_query($connectionManager->getConnection(), $query);
            $connectionManager->closeConnection();

            return $result;
        }

        /**
         * get all user 
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
         * get the specified user info
         * @param $userId
         * @return User
         */
        public function getById($userId) {

            $query = /** @lang text */
                "SELECT * FROM $this->tableName WHERE user_id = $userId";

            $connectionManager = new ConnectionManager();

            $result = mysqli_query($connectionManager->getConnection(), $query);

            $row = $result->fetch_assoc();
            $user = new User();
            $user->userId = $row['user_id'];
            $user->fullName = $row['full_name'];
            $user->username = $row['username'];
            $user->password = $row['password'];

            $connectionManager->closeConnection();

            return $user;
        }

        /**
         * get the users that captions contains the keyword
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

            $lowerUsername = $username;

            $query = /** @lang text */
                "SELECT * FROM ".$this->tableName." WHERE username = '$lowerUsername'";

            $connectionManager = new ConnectionManager();
            $selectedUser = mysqli_query($connectionManager->getConnection(), $query);
            $connectionManager->closeConnection();

            if (!$selectedUser) return false;

            $data = $selectedUser->fetch_assoc();
            return matchPasswords($password, $data['password']);
        }

        /**
         * check a username already registered or not
         * @param $username
         * @return bool
         */
        public function isExists($username) {

            $lowerUsername = $username;
            $query = /** @lang text */
                "SELECT username FROM ".$this->tableName." WHERE username = '$lowerUsername'";

            $connectionManager = new ConnectionManager();
            $selectedUser = mysqli_query($connectionManager->getConnection(), $query);
            $connectionManager->closeConnection();

            if ($selectedUser->num_rows > 0) 
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

            $lowerCurrentUsername = $currentUsername;
            $lowerSelectedUsername = $selectedUsername;

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