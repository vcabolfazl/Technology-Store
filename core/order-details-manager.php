<?php
require_once("connection-manager.php");
require_once("models/order-details.php");

class OrderDetailsManager {

    private $tableName = "orders_details";

    /**
     * add new record to order details tables
     * @param OrderDetails $details
     * @return bool|mysqli_result
     */
    public function add(OrderDetails $details) {

        $fields = "(order_id, customer_id, product_id, product_price, order_quantity)";
        $values = "('$details->orderId', '$details->customerId', '$details->productId', '$details->productPrice', '$details->orderQuantity')";
        $query = /** @lang text */
            "INSERT INTO $this->tableName $fields VALUES $values";

        $connectionManager = new ConnectionManager();
        $result = mysqli_query($connectionManager->getConnection(), $query);
        $connectionManager->closeConnection();

        return $result;
    }

    /**
     * update the order details
     * @param OrderDetails $details
     * @return bool|mysqli_result
     */
    public function update(OrderDetails $details) {
        $newValues = "order_id = '$details->orderId', customer_id = '$details->customerId', product_id = '$details->productId', product_price = '$details->productPrice', order_quantity = '$details->orderQuantity'";
        $query = /** @lang text */
            "UPDATE $this->tableName SET $newValues WHERE order_id = $details->detailsId";

        $connectionManager = new ConnectionManager();
        $result = mysqli_query($connectionManager->getConnection(), $query);
        $connectionManager->closeConnection();

        return $result;
    }

    /**
     * delete specified order details
     * @param $orderDetailsId
     * @return bool|mysqli_result
     */
    public function delete($orderDetailsId) {

        $query = /** @lang text */
            "DELETE FROM $this->tableName WHERE details_id = $orderDetailsId";

        $connectionManager = new ConnectionManager();
        $result = mysqli_query($connectionManager->getConnection(), $query);
        $connectionManager->closeConnection();

        return $result;
    }

    /**
     * delete specified order details by order id
     * @param $orderId
     * @return bool|mysqli_result
     */
    public function deleteByOrderId($orderId) {

        $query = /** @lang text */
            "DELETE FROM $this->tableName WHERE order_id = $orderId";

        $connectionManager = new ConnectionManager();
        $result = mysqli_query($connectionManager->getConnection(), $query);
        $connectionManager->closeConnection();

        return $result;
    }

    /**
     * get all order details
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
     * get the specified order details
     * @param $detailsId
     * @return OrderDetails
     */
    public function getById($detailsId) {

        $query = /** @lang text */
            "SELECT * FROM $this->tableName WHERE details_id = $detailsId";

        $connectionManager = new ConnectionManager();

        $result = mysqli_query($connectionManager->getConnection(), $query);

        $row = $result->fetch_assoc();
        $orderDetails = new OrderDetails();
        $orderDetails->detailsId = $row['details_id'];
        $orderDetails->orderId = $row['order_id'];
        $orderDetails->customerId = $row['customer_id'];
        $orderDetails->productId = $row['product_id'];
        $orderDetails->productPrice = $row['product_price'];
        $orderDetails->orderQuantity = $row['order_quantity'];

        $connectionManager->closeConnection();

        return $orderDetails;
    }

    /**
     * get the specified order details by order id
     * @param $orderId
     * @return array
     */
    public function getByOrderId($orderId) {

        $query = /** @lang text */
            "SELECT * FROM $this->tableName WHERE order_id = $orderId";

        $connectionManager = new ConnectionManager();

        $result = mysqli_query($connectionManager->getConnection(), $query);
        $rows = [];

        while ($row = $result->fetch_assoc())
            $rows[] = $row;

        $connectionManager->closeConnection();
        return $rows;
    }
}