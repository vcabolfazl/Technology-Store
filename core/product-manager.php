<?php 
    require_once("connection-manager.php");
    require_once("models/product.php");

    class ProductManager {

        private $tableName = "products";

        /**
         * add new record to product tables
         */
        public function add(Product $product) {

            $fields = "(caption, description, price, quantity, reg_date, image_url)";
            $values = "('$product->caption', '$product->description', '$product->price', '$product->quantity', '$product->regDate', '$product->imageUrl')";
            $query = "INSERT INTO $this->tableName $fields VALUES $values";

            $connectionManager = new ConnectionManager();         
            $result = mysqli_query($connectionManager->getConnection(), $query);
            $connectionManager->closeConnection();

            return $result;
        }

        /**
         * update the product info
         */
        public function update(Product $product) {
            $newValues = "caption = '$product->caption', description = '$product->description', price = '$product->price', quantity = '$product->quantity', quantity = '$product->quantity', reg_date = '$product->regDate', image_url = '$product->imageUrl'";
            $query = "UPDATE $this->tableName SET $newValues WHERE product_id = $product->productId";
      
            $connectionManager = new ConnectionManager();         
            $result = mysqli_query($connectionManager->getConnection(), $query);
            $connectionManager->closeConnection();

            return $result;
        }

        /**
         * delete sepcified product
         */
        public function delete($productId) {

            $query = "DELETE FROM $this->tableName WHERE product_id = $productId";

            $connectionManager = new ConnectionManager();         
            $result = mysqli_query($connectionManager->getConnection(), $query);
            $connectionManager->closeConnection();

            return $result;
            
        }

        /**
         * get all product 
         */
        public function getAll() {

            $query = "SELECT * FROM $this->tableName";

            $connectionManager = new ConnectionManager();

            $result = mysqli_query($connectionManager->getConnection(), $query);
            $rows = [];

            while ($row = $result->fetch_assoc()) 
                $rows[] = $row;

            $connectionManager->closeConnection();

            return $rows;
        }

        /**
         * get the specified product info
         */
        public function getById($productId) {

            $query = "SELECT * FROM $this->tableName WHERE product_id = $productId";

            $connectionManager = new ConnectionManager();

            $result = mysqli_query($connectionManager->getConnection(), $query);

            $row = $result->fetch_assoc();
            $product = new Product();
            $product->productId = $row['product_id'];
            $product->caption = $row['caption'];
            $product->description = $row['description'];
            $product->price = $row['price'];
            $product->quantity = $row['quantity'];
            $product->regDate = $row['reg_date'];
            $product->imageUrl = $row['image_url'];

            $connectionManager->closeConnection();

            return $product;
        }

        /**
         * get the products that captions contains the keyword
         */
        public function search($keyword) {
            $query = "SELECT * FROM $this->tableName WHERE caption LIKE '%$keyword%'";

            $connectionManager = new ConnectionManager();

            $result = mysqli_query($connectionManager->getConnection(), $query);
            $rows = [];

            while ($row = $result->fetch_assoc()) 
                $rows[] = $row;

            $connectionManager->closeConnection();

            return $rows;
        }
    }
?>