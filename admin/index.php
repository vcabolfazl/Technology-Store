<?php

if (isset($_GET["section"])) {
    $activeSection = $_GET["section"];
} else {
    $activeSection = 0;
}
   
// this variable defined in header file
switch ($activeSection) {
    case 0:
        include("products.php");
        break;
    case 1:
        include("customers.php");
        break;
    case 2:
        include("users.php");
        break;
    case 3:
        include("orders.php");
        break;
    default:
        # code...
        break;
}

require_once ("footer.php");