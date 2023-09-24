<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<?php 
    $messageCode = -1;

    if (isset($_GET["code"]))
        $messageCode = $_GET["code"];

    if ($messageCode < 0) {
        echo "در اجرای عملیات خطایی رخ داده است!";
        return;
    }
?>
</body>
</html>