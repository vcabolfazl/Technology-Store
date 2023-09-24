<div class="loader">
    <img src="./theme/imgs/loading.gif" alt="Loading..." />
</div>
<?php
    require_once("core/resources.php");
    require_once("core/product-manager.php");
    require_once("core/customer-manager.php");
    require_once("core/order-manager.php");
    require_once("core/order-details-manager.php");
    require_once("header.php");

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $sessionsState = isSessionExists("IsCustomerAuthorized") && getSession("IsCustomerAuthorized") == true;

    $paymentMessage = ALT_255;

    if (isset($_POST["pay-submit"])) {
        // check customer login status
        if (!$sessionsState) return;

        $hasError = false;
        $productManager = new ProductManager();
        $customerManager = new CustomerManager();
        $orderManager = new OrderManager();
        $orderDetailsManager = new OrderDetailsManager();

        if (empty($_POST["product-ids"]) && empty($_POST["order-quantities"])) {
            $paymentMessage = "محصولی برای پرداخت انتخاب نشده است!";
        } else {
            // product ids that separated by comma
            $productIds = explode(',', $_POST["product-ids"]);

            // product order quantity that separated by comma
            $orderQuantities = explode(',', $_POST["order-quantities"]);

            // selected products length
            $orderLength = count($productIds);

            try {
                $date = new DateTime("now", new DateTimeZone('Asia/Tehran'));
            } catch (Exception $e) {
            }

            $customerInfo = $customerManager->getByUsername(getSession("CurrentCustomerUsername"));
            $dateTime = $date->format('Y-m-d H:i:s');
            $totalPrice = 0;

            $order = new Order();
            $order->customerId = $customerInfo->customerId;
            $order->totalPrice = $totalPrice;
            $order->totalProducts = $orderLength;
            $order->dateTime = $dateTime;
            $order->paymentStatus = 1;

            $orderId = $orderManager->add($order);

            for ($key = 0; $key < $orderLength; $key++) {
                $orderDetails = new OrderDetails();
                $productInfo = $productManager->getById($productIds[$key]);

                $orderDetails->orderId = $orderId;
                $orderDetails->customerId =  $customerInfo->customerId;
                $orderDetails->productId = $productInfo->productId;
                $orderDetails->productPrice = $productInfo->price;
                $orderDetails->orderQuantity = $orderQuantities[$key];

                if (!$orderDetailsManager->add($orderDetails)) {
                    $hasError = true;
                }

                $productInfo->quantity -= $orderDetails->orderQuantity;
                $productManager->update($productInfo);

                // sum order total price
                $totalPrice += intval($orderQuantities[$key]) * $productInfo->price;
            }

            $order->orderId = $orderId;
            $order->totalPrice = $totalPrice;
            $orderManager->update($order);

            if ($hasError) {
                $paymentMessage = "خطایی در عملیات پرداخت رخ داده است!";
            } else {
                redirectTo(ORDER_RECEIPT_URL . '?oid='. $orderId);
            }
        }
    }
?>

<script>
    let cartItems = JSON.parse(localStorage.getItem(localCartKey));
    let totalPriceForPayment = 0;

    $(".cart-items-section").ready(function() {
        function loadData() {
            let ids = "";
            let quantities = "";
            let idField = $(".product-ids");
            let quantitiesField = $(".order-quantities");

            cartItems.forEach(function (item) {
                ids += item.productId + ",";
                quantities += item.orderQuantity + ",";
            });

            // remove last comma
            ids = ids.substring(0, ids.length-1);
            // remove last comma
            quantities = quantities.substring(0, quantities.length-1);

            idField.val(ids);
            quantitiesField.val(quantities);
        }

        function getProductId(element) {
            if (!element) return -1;
            let row = element.closest("tr");
            let children = row.children();
            return children.find(".product-id").text();
        }

        function getProductQuantity(element) {
            if (!element) return -1;
            let row = element.closest("tr");
            let children = row.children();
            return children.find(".product-quantity").text();
        }

        function updateRowTotalPrice(element) {
            if (!element) return -1;
            let row = element.closest("tr");
            let children = row.children();
            let price = children.find(".row-price").text();
            let quantity = children.find(".quantity").text();

            children.find(".row-total-price").text(Number(price) * Number(quantity));
            updateTotalPrice();
        }

        function updateTotalPrice() {
            let totalPriceSpan = $(".total-price");
            let totalPrice = 0;

            $(".row-total-price").each(function () {
                totalPrice += Number($(this).text());
            });

            totalPriceSpan.text(totalPrice);
        }

        $(".cart-items-section").on("click", ".login", function (e) {
            e.preventDefault();

            let source = document.URL;
            location.href = "<?php echo LOGIN_PAGE_URL;?>?source=" + source;

        });

        $(".cart-items-section").on("click", ".cancel", function () {
            if (cartItems.length < 1) return;

            localStorage.removeItem(localCartKey);
            location.reload();
        });

        if (cartItems.length < 1) return;

        cartItems.forEach(function(item) {
            const rowStartTag = "<tr class='row'>";
            const rowEndTag = "</tr>";
            const rowDataStartTag = "<td>";
            const rowDataEndTag = "</td>";
            const deleteButton = "<button class='delete-from-cart action-button'><i class='fas fa-trash fa-xl'></i></button>";
            const productId = "<span class='product-id'>" + item.productId + "</span>";
            const quantityField = "<div>\n" +
                "    <button class=\"action-tool-button add-quantity\"><i class=\"fas fa-plus\"></i></button>\n" +
                "    <span class=\"quantity\">" + item.orderQuantity + "</span>\n" +
                "    <button class=\"action-tool-button sub-quantity\"><i class=\"fas fa-minus\"></i></button>\n" +
                "</div>";

            let price = "<span class='row-price price'>" + item.price + "</span>";
            let totalPrice = "<span class='row-total-price price'>" + item.price * item.orderQuantity + "</span>";
            let productQuantity = '<span class="product-quantity">' + item.productQuantity + '</span>';

            let row =
                rowStartTag +
                // Product id
                rowDataStartTag + productId + rowDataEndTag +
                // Image
                rowDataStartTag + "<img src='" + item.image + "' alt='" + item.caption + "'/>" + rowDataEndTag +
                // Caption
                rowDataStartTag + item.caption + rowDataEndTag +
                // Product quantity
                rowDataStartTag + productQuantity + rowDataEndTag +
                // Quantity
                rowDataStartTag + quantityField + rowDataEndTag +
                // Unit price
                rowDataStartTag + price + rowDataEndTag +
                // Total Price
                rowDataStartTag + totalPrice + rowDataEndTag +
                // Delete button
                rowDataStartTag + deleteButton + rowDataEndTag +
                // End of row
                rowEndTag;

            $(".list-header").after(row);
            totalPriceForPayment += item.price * item.orderQuantity;
        });

        $(".items-count").text(cartItems.length);
        $(".total-price").text(totalPriceForPayment);

        loadData();

        $("table").on("click", ".delete-from-cart", function () {
            let deleteButton = $(this);
            let productId = getProductId(deleteButton);

            for (let i = 0; i < cartItems.length; i++) {
                if (Number(cartItems[i].productId) === Number(productId)) {
                    cartItems.splice(i, 1);
                    break;
                }
            }

            localStorage.setItem(localCartKey, JSON.stringify(cartItems));
            location.reload();
        });

        $("table").on("click", ".add-quantity", function () {
            let addButton = $(this);
            let quantitySpan = addButton.next();
            let currentValue = quantitySpan.text();
            let newValue = ++currentValue;
            let productId = getProductId(addButton);
            let productQuantity = getProductQuantity(addButton);

            if (currentValue > productQuantity) {
                return;
            }

            for (let i = 0; i < cartItems.length; i++) {
                if (Number(cartItems[i].productId) === Number(productId)) {
                    cartItems[i].orderQuantity = newValue;
                    break;
                }
            }

            localStorage.setItem(localCartKey, JSON.stringify(cartItems));
            quantitySpan.text(newValue);
            updateRowTotalPrice(addButton);
            loadData();
        });

        $("table").on("click", ".sub-quantity", function () {
            let subButton = $(this);
            let quantitySpan = subButton.prev();
            let currentValue = quantitySpan.text();

            if (currentValue <= 1) return;

            let newValue = --currentValue;
            let productId = getProductId(subButton);

            for (let i = 0; i < cartItems.length; i++) {
                if (Number(cartItems[i].productId) === Number(productId)) {
                    cartItems[i].orderQuantity = newValue;
                    break;
                }
            }

            localStorage.setItem(localCartKey, JSON.stringify(cartItems));
            quantitySpan.text(newValue);
            updateRowTotalPrice(subButton);
            loadData();
        });
    });
</script>

<section class="cart-items-section">
    <div class="caption">
        <h1><?php echo SHOPPING_CART_CAPTION; ?></h1>
    </div>

    <div class="message">
        <span class="error-message"><?php echo $paymentMessage; ?></span>
    </div>

    <div class="items">
        <table>
            <tbody>
                <tr class="list-header">
                    <th><?php echo ID; ?></th>
                    <th><?php echo IMAGE; ?></th>
                    <th><?php echo CAPTION; ?></th>
                    <th><?php echo AMOUNT; ?></th>
                    <th><?php echo QUANTITY; ?></th>
                    <th><?php echo UNIT_PRICE; ?></th>
                    <th><?php echo TOTAL_PRICE; ?></th>
                    <th><?php echo DELETE; ?></th>
                </tr>

            </tbody>
        </table>

        <div class="list-footer">
            <div class="details">
                <div>
                    <span><?php echo TOTAL_QUANTITY; ?>: </span><span class="items-count"></span>
                </div>

                <div>
                    <span><?php echo TOTAL_PRICE; ?>: </span><span class="total-price price"></span>
                </div>
            </div>

            <div class="buttons">
                <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                    <a class="link-button cancel"><?php echo CANCEL; ?></a>

                    <?php if ($sessionsState ) {  ?>
                        <input type="hidden" name="product-ids" class="product-ids">
                        <input type="hidden" name="order-quantities" class="order-quantities">
                        <button class="primary-button primary" type="submit" name="pay-submit"><?php echo PAY; ?></button>
                    <?php } else {  ?>
                        <button class="primary-button primary login" ><?php echo LOGIN; ?></button>
                    <?php }  ?>
                </form>
            </div>

        </div>
    </div>
</section>

<?php require_once("footer.php"); ?>

