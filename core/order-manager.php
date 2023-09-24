<?php
require_once("connection-manager.php");
require_once("order-details-manager.php");
require_once("models/order.php");

class OrderManager {

    private $tableName = "orders";

    /**
     * add new record to order tables
     * @param Order $order
     * @return int|string
     */
    public function add(Order $order) {

        $fields = "(customer_id, total_products, total_price, date_time, payment_status)";
        $values = "('$order->customerId', '$order->totalProducts', '$order->totalPrice', '$order->dateTime', '$order->paymentStatus')";
        $query = /** @lang text */
            "INSERT INTO $this->tableName $fields VALUES $values";

        $connectionManager = new ConnectionManager();
        mysqli_query($connectionManager->getConnection(), $query);
        $insertId = mysqli_insert_id($connectionManager->getConnection());
        $connectionManager->closeConnection();

        return $insertId;
    }

    /**
     * update the order info
     * @param Order $order
     * @return bool|mysqli_result
     */
    public function update(Order $order) {
        $newValues = "customer_id = '$order->customerId', total_products = '$order->totalProducts', total_price = '$order->totalPrice', date_time = '$order->dateTime', payment_status = '$order->paymentStatus'";
        $query = /** @lang text */
            "UPDATE $this->tableName SET $newValues WHERE order_id = $order->orderId";

        $connectionManager = new ConnectionManager();
        $result = mysqli_query($connectionManager->getConnection(), $query);
        $connectionManager->closeConnection();

        return $result;
    }

    /**
     * delete specified order
     * @param $orderId
     * @return bool|mysqli_result
     */
    public function delete($orderId) {

        $orderDetailsManager = new OrderDetailsManager();
        $orderDetailsManager->deleteByOrderId($orderId);

        $query = /** @lang text */
            "DELETE FROM $this->tableName WHERE order_id = $orderId";

        $connectionManager = new ConnectionManager();
        $result = mysqli_query($connectionManager->getConnection(), $query);
        $connectionManager->closeConnection();

        return $result;
    }

    /**
     * get all order
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
     * get the specified order info
     * @param $orderId
     * @return Order
     */
    public function getById($orderId) {

        $query = /** @lang text */
            "SELECT * FROM $this->tableName WHERE order_id = $orderId";

        $connectionManager = new ConnectionManager();

        $result = mysqli_query($connectionManager->getConnection(), $query);

        $row = $result->fetch_assoc();
        $order = new Order();
        $order->orderId = $row['order_id'];
        $order->customerId = $row['customer_id'];
        $order->totalProducts = $row['total_products'];
        $order->totalPrice = $row['total_price'];
        $order->dateTime = $row['date_time'];
        $order->paymentStatus = $row['payment_status'];

        $connectionManager->closeConnection();

        return $order;
    }

    /**
     * get the specified customer orders
     * @param $customerId
     * @return array
     */
    public function getOrdersByCustomerId($customerId) {

        $query = /** @lang text */
            "SELECT * FROM $this->tableName WHERE customer_id = $customerId";

        $connectionManager = new ConnectionManager();
        $result = mysqli_query($connectionManager->getConnection(), $query);
        $rows = [];

        while ($row = $result->fetch_assoc())
            $rows[] = $row;

        $connectionManager->closeConnection();
        return $rows;
    }
}