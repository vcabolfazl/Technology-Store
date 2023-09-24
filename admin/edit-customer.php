<?php 
    require_once("../core/resources.php");
    require_once("../core/utilities.php");
    require_once("../core/customer-manager.php");

    setPageTitle(EDIT_USER_TITLE);
    require_once("header.php"); 
    
    $fullName = NULL;
    $username = NULL;
    $password = NULL;
    $phone = NULL;
    $address = NULL;
    $actionMessages = ALT_255;
    $customerManager = new CustomerManager();
    $customerId = 0;

    if (isset($_GET["cid"]))
        $customerId = intval($_GET["cid"]);

    if ($customerId < 1) {
        redirectTo(ERROR_PAGE_URL);
        return;
    }

    $customerInfo = $customerManager->getById($customerId);
    $fullName = $customerInfo->fullName;
    $username = $customerInfo->username;
    $password = $customerInfo->password;
    $phone = $customerInfo->phone;
    $address = $customerInfo->address;

    if ($customerInfo->customerId == NULL) {
        redirectTo(ERROR_PAGE_URL."?code=2001");
    }

    if (isset($_POST["submit"])) {

        $fullName = $_POST["full-name"];
        $username = $_POST["username"];
        $password = $_POST["password"];
        $phone = $_POST["phone"];
        $address = $_POST["address"];

        if (empty($fullName) || empty($username) || empty($password)) {
            $actionMessages = ADD_CUSTOMER_EMPTY_FIELD_MESSAGE;
        } else {         

            if ($customerManager->isExistsForEdit($username, $customerInfo->username)) {
                $actionMessages = USERNAME_EXISTENCE_ERROR_MESSAGE;
            } else {
                $isNeedToHash =  $customerInfo->password != $password;

                $customerInfo->fullName = $fullName;
                $customerInfo->username = $username;
                $customerInfo->password = $password;
                $customerInfo->phone = $phone;
                $customerInfo->address = $address;

                if ($customerManager->update($customerInfo, $isNeedToHash))
                    $actionMessages = EDIT_CUSTOMER_SUCCESS_MESSAGE;
                else 
                    $actionMessages = EDIT_CUSTOMER_FAILED_MESSAGE;

                $fullName = NULL;
                $username = NULL;
                $password = NULL;
                $phone = NULL;
                $address = NULL;
            }
        }        
    }
?>

<section class="add-new-user">
    
<h1><?php echo EDIT_CUSTOMER; ?></h1>

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

            <div class="phone-field">
                <input type="tel" class="text-box" name="phone" placeholder="<?php echo PHONE; ?>" value="<?php echo $phone; ?>">
            </div>      

            <div class="address-field">
                <input type="text" class="text-box" name="address" placeholder="<?php echo ADDRESS; ?>" value="<?php echo $address; ?>">
            </div>      
            
            <div class="buttons">
                <button class="primary-button" type="submit" name="submit"><?php echo EDIT; ?></button>
            </div>  
    </form>
</section>