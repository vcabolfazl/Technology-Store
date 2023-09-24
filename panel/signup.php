<?php 
    require_once("../core/resources.php");
    require_once("../core/utilities.php");
    require_once("../core/customer-manager.php");

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $sessionsState = isSessionExists("IsCustomerAuthorized") && getSession("IsCustomerAuthorized") == true;

    if ($sessionsState) {
        redirectTo(LOGIN_PAGE_URL);
    }

    $fullName = NULL;
    $username = NULL;
    $password = NULL;
    $phone = NULL;
    $address = NULL;
    $actionMessages = ALT_255;
    $customerManager = new CustomerManager();

    if (isset($_POST["submit"])) {

        $fullName = $_POST["full-name"];
        $username = $_POST["username"];
        $password = $_POST["password"];
        $phone = $_POST["phone"];
        $address = $_POST["address"];

        if (empty($fullName) || empty($username) || empty($password)) {
            $actionMessages = "فیلد های نام کاربری، کلمه عبور و نام نمی توانند خالی باشند!";
        } else {

            if ($customerManager->isExists($username)) {
                $actionMessages = USERNAME_EXISTENCE_ERROR_MESSAGE;
            } else {
                $customerInfo = new Customer();
                $customerInfo->fullName = $fullName;
                $customerInfo->username = $username;
                $customerInfo->password = $password;
                $customerInfo->phone = $phone;
                $customerInfo->address = $address;

                if ($customerManager->add($customerInfo)) {
                    $_SESSION["IsCustomerAuthorized"] = true;
                    $_SESSION["CurrentCustomerUsername"] = $username;
                    redirectTo(CUSTOMER_CONTROL_PANEL_URL);
                } else {
                    $actionMessages = "خطایی در ایجاد حساب شما رخ داده است!";
                }


                $fullName = NULL;
                $username = NULL;
                $password = NULL;
                $phone = NULL;
                $address = NULL;
            }
        }
    }

    setPageTitle(CUSTOMER_SIGNUP_TITLE);
    require_once("../header.php");
?>


<!-- signup form section -->
<section class="signup-form-container">

    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" class="signup-form card" method="post">

        <div class="form-caption">
            <h3><?php echo CREATE_ACCOUNT ?></h3>
        </div>

        <div class="form-error">
            <span class="error-message"><?php echo $actionMessages; ?></span>
        </div>

        <div class="full-name-field">
            <input type="text" class="text-box" name="full-name" placeholder="<?php echo FULL_NAME; ?>" value="<?php echo $fullName; ?>">
        </div>

        <div class="username-field">
            <input type="text" class="text-box" name="username" placeholder="<?php echo USERNAME; ?>" value="<?php echo $username; ?>">
        </div>

        <div class="password-field">
            <input type="password" class="text-box" name="password" placeholder="<?php echo PASSWORD; ?>" value="<?php echo $password; ?>">
        </div>

        <div class="phone-field">
            <input type="tel" class="text-box" name="phone" placeholder="<?php echo PHONE; ?>" value="<?php echo $phone; ?>">
        </div>

        <div class="address-field">
            <input type="text" class="text-box" name="address" placeholder="<?php echo ADDRESS; ?>" value="<?php echo $address; ?>">
        </div>

        <br>

        <div class="buttons">
            <button class="primary-button" type="submit" name="submit"><?php echo CREATE_ACCOUNT; ?></button>
            <a class="link-button" href="<?php echo LOGIN_PAGE_URL; ?>"><?php echo LOGIN; ?></a>
        </div>
    </form>
</section>

<?php require_once("../footer.php"); ?>