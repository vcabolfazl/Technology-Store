<?php
    require_once("../core/resources.php");
    require_once("../core/utilities.php");
    require_once("../core/user-manager.php");

    $userManager = new UserManager();
    $users = $userManager->getAll();

    if (count($users) < 1)
        redirectTo(FIRST_USER_SIGNUP_URL."?source=".CONTROL_PANEL_URL);

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $sessionsState = isSessionExists("IsAuthorized") && getSession("IsAuthorized") == true;

    if (!$sessionsState) {
        redirectTo(CONTROL_PANEL_LOGIN_URL);
    }

    if (isset($_GET["section"])) {
        $activeSection = $_GET["section"];
    } else {
        $activeSection = 0;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $GLOBALS["CurrentPageTitle"]; ?></title>

    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.0.min.js"></script>
    <script src="http://cdn.ckeditor.com/4.6.2/standard-all/ckeditor.js"></script>
    <script src="js/script.js"></script>

</head>
<body>

<?php require_once("right-sidebar.php"); ?>