<div class="loader">
    <img src="./theme/imgs/loading.gif" alt="Loading..." />
</div>
<?php
    require_once("../core/resources.php");
    require_once("../core/utilities.php");
    require_once("../core/user-manager.php");

    $loginError = ALT_255;
    $username = NULL;
    $password = NULL;
    $userManager = new UserManager();
    $users = $userManager->getAll();

    if (count($users) < 1)
        redirectTo(FIRST_USER_SIGNUP_URL."?source=".CONTROL_PANEL_LOGIN_URL);

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $sessionsState = isSessionExists("IsAuthorized") && getSession("IsAuthorized") == true;

    if ($sessionsState) {
        redirectTo(CONTROL_PANEL_URL);
    }

    if (isset($_POST["submit"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];
        $loginResult = $userManager->login($username, $password);

        if ($loginResult) {
            $_SESSION["IsAuthorized"] = true;
            redirectTo(CONTROL_PANEL_URL);
        } else {
            $loginError = LOGIN_ERROR_MESSAGE;
        }
    }  
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo ADMIN_LOGIN_CAPTION; ?></title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <!-- login form section -->
    <section class="login-form-container">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="login-form card">

            <div class="form-caption">
                <h3><?php echo ADMIN_LOGIN_CAPTION; ?></h3>
            </div>

            <div class="form-error">
                <span class="error-message"><?php echo $loginError; ?></span>
            </div>
            
            <div class="username-field">
                <input type="text" class="text-box" name="username" placeholder="<?php echo USERNAME; ?>" value="<?php echo $username; ?>">
            </div>

            <div class="password-field">
                <input type="password" class="text-box" name="password" placeholder="<?php echo PASSWORD; ?>" value="<?php echo $password; ?>">
            </div>       
            
            <div class="buttons">
                <button class="primary-button" type="submit" name="submit"><?php echo LOGIN; ?></button>
            </div>   

        </form>
    </section>
</body>
</html>