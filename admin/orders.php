<?php
require_once("../core/resources.php");
require_once("../core/utilities.php");
require_once("../core/order-manager.php");
require_once("../core/customer-manager.php");

$actionMessages = ALT_255;
$orderManager = new OrderManager();
$customerManager = new CustomerManager();
$orders = $orderManager->getAll();

if (isset($_GET["action"]) && $_GET["action"] == "delete") {
    if (isset($_GET["oid"])) {
        $orderId = intval($_GET["oid"]);
        if ($orderId > 0) {

            if ($orderManager->delete($orderId))
                redirectTo(CONTROL_PANEL_URL.'?section='.$activeSection.'&result=1');
            else
                redirectTo(CONTROL_PANEL_URL.'?section='.$activeSection.'&result=0');
        }
    }
}

if (isset($_GET["result"])) {
    if ($_GET["result"] == 1) {
        $actionMessages = SUCCESS_DELETE_MESSAGE;
    } else  {
        $actionMessages = FAILED_DELETE_MESSAGE;
    }
}

setPageTitle(ORDERS_LIST_TITLE);
require_once("header.php");
?>

<section class="users">

    <section class="caption">
        <h4><?php echo ORDERS; ?></h4>
    </section>

    <section class="message">
        <p><?php echo $actionMessages ?></p>
    </section>

    <section class="list">
        <table>
            <tr>
                <th><?php echo INDEX; ?></th>
                <th><?php echo ID; ?></th>
                <th><?php echo CUSTOMER; ?></th>
                <th><?php echo PRODUCTS_COUNT; ?></th>
                <th><?php echo TOTAL_PRICE; ?></th>
                <th><?php echo DATE_TIME; ?></th>
                <th><?php echo PAYMENT_STATUS; ?></th>
                <th><?php echo BUY_DETAILS; ?></th>
                <th><?php echo DELETE; ?></th>
            </tr>

            <!-- contents -->
            <?php
            $index = 1;

            // create items
            foreach($orders as &$order) {
                $customerInfo = $customerManager->getById($order['customer_id']);
                $deleteUrl = CONTROL_PANEL_URL."?section=".$activeSection."&oid=".$order['order_id']."&action=delete";
                $paymentStatus = $order["payment_status"] == 1 ? SUCCESS : FAILED;
                $orderStatusSpanClass = $order["payment_status"] == 1 ? "success-payment" : "failed-payment";
                $orderDetailsUrl = ORDER_DETAILS_URL."?oid=". $order['order_id'];

                echo '<tr>';
                echo '<td>'.$index++.'</td>';
                echo '<td>'.$order['order_id'].'</td>';
                echo '<td>'.$customerInfo->fullName.'</td>';
                echo '<td>'.$order['total_products'].'</td>';
                echo '<td><span class="price">'.$order['total_price'].'</span></td>';
                echo '<td>'.$order['date_time'].'</td>';
                echo '<td><span class="'.$orderStatusSpanClass.'">'.$paymentStatus.'</span></td>';
                echo '<td><a href="'.$orderDetailsUrl.'" target="_blank" class="action-button"><i class="fas fa-external-link-alt fa-sm"></i></a></td>';
                echo '<td><a href="'.$deleteUrl.'" class="action-button"><i class="fas fa-trash-alt fa-xl"></i></a></td>';
                echo '</tr>';
            }
            ?>
        </table>
    </section>

</section>
