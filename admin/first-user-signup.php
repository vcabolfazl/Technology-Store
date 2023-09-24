<?php 
    require_once("../core/resources.php");
    require_once("../core/utilities.php");
    require_once("../core/user-manager.php");

    $fullName = NULL;
    $username = NULL;
    $password = NULL;

    if (isset($_GET["source"]))
        $refererPage = $_GET["source"];                    
    else        
        $refererPage = CONTROL_PANEL_LOGIN_URL;

    $userManager = new UserManager();
    $users = $userManager->getAll();

    if (count($users) > 0)
        redirectTo($refererPage);

    if (isset($_POST["submit"])) {

        $fullName = $_POST["full-name"];
        $username = $_POST["username"];
        $password = $_POST["password"];

        if (empty($fullName) || empty($username) || empty($password)) {
            $signupError = SIGNUP_EMPTY_FIELD_ERROR_MESSAGE;
        } else {         

            if ($userManager->isExists($username)) {
                $signupError = USERNAME_EXISTENCE_ERROR_MESSAGE;
            } else {
                $userInfo = new User();
                $userInfo->fullName = $fullName;
                $userInfo->username = $username;
                $userInfo->password = $password;

                $userManager->add($userInfo);

                redirectTo($refererPage);
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo FIRST_USER_SIGNUP_CAPTION; ?></title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <!-- sign up form section -->
    <section class="signup-form-container">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="signup-form card">

            <div class="form-caption">
                <h3><?php echo FIRST_USER_SIGNUP_CAPTION ?></h3>
            </div>

            <div class="form-error">
                <span class="error-message">
                <?php
                    if (isset($signupError)) 
                        echo $signupError;
                    else 
                        echo ALT_255;
                ?>
                </span>
            </div>

            <div class="username-field">
                <input type="text" class="text-box" name="full-name" placeholder="<?php echo FULL_NAME; ?>" value="<?php echo $fullName; ?>">
            </div>
            
            <div class="username-field">
                <input type="text" class="text-box" name="username" placeholder="<?php echo USERNAME; ?>" value="<?php echo $username; ?>">
            </div>

            <div class="password-field">
                <input type="password" class="text-box" name="password" placeholder="<?php echo PASSWORD; ?>" value="<?php echo $password; ?>">
            </div>       
            
            <div class="buttons">
                <button class="primary-button" type="submit" name="submit"><?php echo CREATE_ACCOUNT; ?></button>
            </div>  

        </form>
    </section>
</body>
</html>