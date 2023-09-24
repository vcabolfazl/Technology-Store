<?php 
    require_once("core/resources.php");
    require_once("core/utilities.php");
    require_once("core/user-manager.php");

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $sessionsState = isSessionExists("IsCustomerAuthorized") && getSession("IsCustomerAuthorized") == true;

    $userManager = new UserManager();
    $users = $userManager->getAll();

    if (count($users) < 1)
        redirectTo(FIRST_USER_SIGNUP_URL."?source=".HOME_PAGE_URL);
?>

<html>
    <head>
        <title><?php echo getPageTitle(); ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <!-- Css styles -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>theme/normalize.css">
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>theme/style.css">

        <!-- Scripts -->
        <script src="<?php echo BASE_URL; ?>js/jquery-3.4.0.min.js"></script>
        <script src="<?php echo BASE_URL; ?>js/script.js"></script>
    </head>

    <body>
        <header>
            <!-- site logo -->
            <div class="logo-wrapper">
                <a href="<?php echo BASE_URL; ?>">
                    <img class="header-logo" src="<?php echo MAIN_LOGO; ?>" alt="Site logo"/>
                </a>
            </div>
            
            <!-- menu -->
            <nav class="main-menu">
                <ul>
                    <?php
                        if ($sessionsState) {
                            echo '<li><a href="'.CUSTOMER_CONTROL_PANEL_URL.'">سلام '.getSession("CurrentCustomerUsername").'</a></li>';
                        } else {
                            echo '<li><a href="'.SIGNUP_PAGE_URL.'">'.CREATE_ACCOUNT.'</a></li>';
                            echo '<li><a href="'.LOGIN_PAGE_URL.'">'.LOGIN.'</a></li>';
                        }
                    ?>
                    <li><a href="<?php echo BASE_URL; ?>" class="active-page-menu-item"><?php echo HOME; ?></a></li>
                    <li><a href="http://127.0.0.1/shop/index.php?section=1" class="active-page-menu-item"> کیس کامپیوتر </a></li>
                    <li><a href="http://127.0.0.1/shop/section1.php" class="active-page-menu-item">لپ تاپ</a></li>
                    <li><a href="http://127.0.0.1/shop/section2.php" class="active-page-menu-item"> کنسول بازی </a></li>
                    <!-- <li><a href="http://127.0.0.1/shop/index.php?section=4" class="active-page-menu-item"> لوازم جانبی </a></li> -->
                </ul>
            </nav>

            <!-- shop basket -->
            <div class="basket">
                <a class="basket-button" href="<?php echo BASKET_PAGE_URL; ?>">
                    <span class="badge" id="badge">0</span>
                    <i class="fas fa-shopping-bag fa-2x"></i>
                </a>
            </div>
        </header>

        <div class="clear-both"></div>
        <br><br>