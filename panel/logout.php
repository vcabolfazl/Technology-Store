<?php 
    require_once("../core/resources.php");
    require_once("../core/utilities.php");

    session_start();

    $refererPage = HOME_PAGE_URL;
    $sessionsState = isSessionExists("IsCustomerAuthorized") && getSession("IsCustomerAuthorized") == true;

    if ($sessionsState) {
        unset($_SESSION["IsCustomerAuthorized"]);
    }

    if (isset($_GET["source"]))
        $refererPage = $_GET["source"];

    redirectTo($refererPage);
