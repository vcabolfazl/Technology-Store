<?php
    require_once ("../core/resources.php");
    require_once ("../core/utilities.php");
    require_once ("../core/customer-manager.php");
    require_once ("../core/order-manager.php");

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $sessionsState = isSessionExists("IsCustomerAuthorized") && getSession("IsCustomerAuthorized") == true;

    if (!$sessionsState) {
        redirectTo(LOGIN_PAGE_URL);
    }

    $fullName = NULL;
    $username = NULL;
    $phone = NULL;
    $address = NULL;
    $accountInfoSectionMessages = ALT_255;
    $changePasswordSectionMessages = ALT_255;
    $customerManager = new CustomerManager();

    $customerInfo = $customerManager->getByUsername(getSession("CurrentCustomerUsername"));
    $fullName = $customerInfo->fullName;
    $username = $customerInfo->username;
    $phone = $customerInfo->phone;
    $address = $customerInfo->address;

    $orderManager = new OrderManager();
    $customerOrders = $orderManager->getOrdersByCustomerId($customerInfo->customerId);

    if (isset($_POST["submit-account-info"])) {

        $fullName = $_POST["full-name"];
        $username = $_POST["username"];
        $phone = $_POST["phone"];
        $address = $_POST["address"];

        if (empty($username)) {
            $accountInfoSectionMessages = "نام کاربری نمی تواند خالی باشد!";
        } else {

            if ($customerManager->isExistsForEdit($username, $customerInfo->username)) {
                $accountInfoSectionMessages = USERNAME_EXISTENCE_ERROR_MESSAGE;
            } else {
                $customerInfo->fullName = $fullName;
                $customerInfo->username = $username;
                $customerInfo->phone = $phone;
                $customerInfo->address = $address;

                if ($customerManager->update($customerInfo, false))
                    $accountInfoSectionMessages = "اطلاعات شما با موفقیت ویرایش شد.";
                else
                    $accountInfoSectionMessages = "خطایی در ویرایش اطلاعات رخ داده است!";
            }
        }
    }

    $currentPassword = NULL;
    $newPassword = NULL;
    $newPasswordConfirm = NULL;

    if (isset($_POST["submit-change-password"])) {

        $currentPassword = $_POST["current-password"];
        $newPassword = $_POST["new-password"];
        $newPasswordConfirm = $_POST["new-password-confirm"];

        if (empty($currentPassword) || empty($newPassword)) {
            $changePasswordSectionMessages = SIGNUP_EMPTY_FIELD_ERROR_MESSAGE;
        } else if ($newPassword != $newPasswordConfirm) {
            $changePasswordSectionMessages = "تایید کلمه عبور درست نیست!";
        } else {
            $customerInfo = $customerManager->getByUsername(getSession("CurrentCustomerUsername"));

            if (matchPasswords($currentPassword, $customerInfo->password)) {
                $customerInfo->password = $newPassword;

                if ($customerManager->update($customerInfo, true))
                    $changePasswordSectionMessages = "کلمه عبور شما با موفقیت تغییر کرد.";
                else
                    $changePasswordSectionMessages = "خطایی در تغییر کلمه عبور رخ داده است!";
            } else {
                $changePasswordSectionMessages = "کلمه عبور فعلی شما درست نیست!";
            }
        }
    }

    require_once ("../header.php");
?>
<section class="customer-panel">
    <div class="caption">
        <h1><?php echo CUSTOMER_PANEL; ?></h1>
    </div>

    <div class="content">
        <div class="tab-menu">
            <button class="account-info-button"><?php echo ACCOUNT_INFO ?></button>
            <button class="change-password-button"><?php echo CHANGE_PASSWORD ?></button>
            <button class="orders-button"><?php echo ORDERS ?></button>
            <button class="logout-button"><?php echo LOGOUT ?></button>
        </div>

        <div class="menu-item-content">
            <div class="account-info">
                <div>
                    <h4><?php echo ACCOUNT_INFO; ?></h4>
                </div>

                <div class="message">
                    <p><?php echo $accountInfoSectionMessages ?></p>
                </div>

                <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                    <div class="full-name-field">
                        <input type="text" class="text-box" name="full-name" placeholder="<?php echo FULL_NAME; ?>" value="<?php echo $fullName; ?>">
                    </div>

                    <div class="username-field">
                        <input type="text" class="text-box" name="username" placeholder="<?php echo USERNAME; ?>" value="<?php echo $username; ?>">
                    </div>

                    <div class="phone-field">
                        <input type="tel" class="text-box" name="phone" placeholder="<?php echo PHONE; ?>" value="<?php echo $phone; ?>">
                    </div>

                    <div class="address-field">
                        <input type="text" class="text-box" name="address" placeholder="<?php echo ADDRESS; ?>" value="<?php echo $address; ?>">
                    </div>

                    <br>

                    <div class="buttons">
                        <button class="primary-button" type="submit" name="submit-account-info"><?php echo EDIT; ?></button>
                    </div>
                </form>
            </div>

            <div class="change-password">
                <div>
                    <h4><?php echo CHANGE_PASSWORD; ?></h4>
                </div>

                <div class="message">
                    <p><?php echo $changePasswordSectionMessages ?></p>
                </div>

                <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                    <div class="password-field">
                        <input type="password" class="text-box" name="current-password" placeholder="<?php echo CURRENT_PASSWORD; ?>">
                    </div>

                    <div class="password-field">
                        <input type="password" class="text-box" name="new-password" placeholder="<?php echo NEW_PASSWORD; ?>">
                    </div>

                    <div class="password-field">
                        <input type="password" class="text-box" name="new-password-confirm" placeholder="<?php echo NEW_PASSWORD_CONFIRM; ?>">
                    </div>

                    <br>

                    <div class="buttons">
                        <button class="primary-button" type="submit" name="submit-change-password"><?php echo EDIT; ?></button>
                    </div>
                </form>
            </div>

            <div class="orders-details">
                <div>
                    <h4><?php echo ORDERS; ?></h4>
                </div>

                <table>
                    <tr class="list-header">
                        <th><?php echo ID; ?></th>
                        <th><?php echo PRODUCTS_COUNT; ?></th>
                        <th><?php echo TOTAL_PRICE; ?></th>
                        <th><?php echo DATE_TIME; ?></th>
                        <th><?php echo PAYMENT_STATUS; ?></th>
                        <th><?php echo BUY_DETAILS; ?></th>
                    </tr>

                    <?php
                    foreach ($customerOrders as &$orderInfo) {
                        $orderStatus = $orderInfo["payment_status"] == 1 ? SUCCESS : FAILED;
                        $orderStatusSpanClass = $orderInfo["payment_status"] == 1 ? "success-payment" : "failed-payment";
                        $orderDetailsUrl = ORDER_RECEIPT_URL."?oid=". $orderInfo['order_id'];
                    ?>
                        <tr>
                            <td><?php echo $orderInfo['order_id']; ?></td>
                            <td><?php echo $orderInfo['total_products']; ?></td>
                            <td><span class="price"><?php echo $orderInfo['total_price']; ?></span></td>
                            <td><?php echo $orderInfo['date_time']; ?></td>
                            <td><span class="<?php echo $orderStatusSpanClass; ?>"><?php echo $orderStatus; ?></span></td>
                            <td><a href="<?php echo $orderDetailsUrl; ?>" target="_blank" class="action-button"><i class="fas fa-external-link-alt fa-xl"></i></a></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</section>
<?php require_once ("../footer.php"); ?>