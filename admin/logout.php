<div class="loader">
    <img src="./theme/imgs/loading.gif" alt="Loading..." />
</div>
<?php 
    require_once("../core/resources.php");
    require_once("../core/utilities.php");

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $refererPage = CONTROL_PANEL_LOGIN_URL;
    $sessionsState = isSessionExists("IsAuthorized") && getSession("IsAuthorized") == true;

    if ($sessionsState) {
        unset($_SESSION["IsAuthorized"]);
    } 

    if (isset($_GET["source"]))
        $refererPage = $_GET["source"];

    redirectTo($refererPage);
?>