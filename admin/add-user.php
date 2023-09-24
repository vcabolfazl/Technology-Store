<?php 
    require_once("../core/resources.php");
    require_once("../core/utilities.php");
    require_once("../core/user-manager.php");

    setPageTitle(ADD_USER_TITLE);

    require_once("header.php"); 
    
    $fullName = NULL;
    $username = NULL;
    $password = NULL;
    $actionMessages = ALT_255;
    $userManager = new UserManager();

    if (isset($_POST["submit"])) {

        $fullName = $_POST["full-name"];
        $username = $_POST["username"];
        $password = $_POST["password"];

        if (empty($fullName) || empty($username) || empty($password)) {
            $actionMessages = SIGNUP_EMPTY_FIELD_ERROR_MESSAGE;
        } else {         

            if ($userManager->isExists($username)) {
                $actionMessages = USERNAME_EXISTENCE_ERROR_MESSAGE;
            } else {
                $userInfo = new User();
                $userInfo->fullName = $fullName;
                $userInfo->username = $username;
                $userInfo->password = $password;

                if ($userManager->add($userInfo))
                    $actionMessages = ADD_USER_SUCCESS_MESSAGE;
                else 
                    $actionMessages = ADD_USER_FAILED_MESSAGE;

                $fullName = NULL;
                $username = NULL;
                $password = NULL;
            }
        }        
    }
?>

<section class="add-new-user">
    
<h1><?php echo ADD_NEW_USER; ?></h1>

    <section class="message">
        <p><?php echo $actionMessages ?></p>
    </section>

    <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST" class="add-form">

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