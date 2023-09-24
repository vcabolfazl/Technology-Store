<?php 
    require_once("../core/resources.php");
    require_once("../core/utilities.php");
    require_once("../core/customer-manager.php");

    $source = CUSTOMER_CONTROL_PANEL_URL;
    $loginError = ALT_255;
    $username = NULL;
    $password = NULL;
    $customerManager = new CustomerManager();

    if (isset($_GET["source"])) {
        $source = $_GET["source"];
    }

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $sessionsState = isSessionExists("IsCustomerAuthorized") && getSession("IsCustomerAuthorized") == true;

    if ($sessionsState) {
        redirectTo(CUSTOMER_CONTROL_PANEL_URL);
    }

    if (isset($_POST["submit"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];
        $loginResult = $customerManager->login($username, $password);

        if ($loginResult) {
            $_SESSION["IsCustomerAuthorized"] = true;
            $_SESSION["CurrentCustomerUsername"] = $username;

            redirectTo($source);
        } else {
            $loginError = LOGIN_ERROR_MESSAGE;
        }
    }

setPageTitle(CUSTOMER_LOGIN_TITLE);
    require_once("../header.php");
?>

<!-- login form section -->
<section class="login-form-container">
    <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" class="login-form card" method="post">

        <div class="form-caption">
            <h3><?php echo LOGIN_TO_ACCOUNT ?></h3>
        </div>

        <div class="form-error">
            <span class="error-message"><?php echo $loginError; ?></span>
        </div>
        
        <div class="username-field">
            <input type="text" class="text-box" name="username" placeholder="<?php echo USERNAME; ?>">
        </div>

        <div class="password-field">
            <input type="password" class="text-box" name="password" placeholder="<?php echo PASSWORD; ?>">
        </div>       
        
        <div class="buttons">
            <button class="primary-button" type="submit" name="submit"><?php echo LOGIN; ?></button>
            <a class="link-button" href="<?php echo SIGNUP_PAGE_URL; ?>"><?php echo CREATE_ACCOUNT; ?></a>
        </div>
    </form>
</section>

<?php require_once("../footer.php"); ?>