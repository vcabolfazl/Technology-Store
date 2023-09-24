<?php
require_once('connection-manager.php');
require_once('header.php');
require_once("core/resources.php");
require_once("core/utilities.php");
require_once("core/user-manager.php");
?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="chat, user, comments, wide" />

    <title>Comment Section With Flexbox</title>

    <link rel="stylesheet" href="styles.css">

</head>

<body dir="">

    <ul class="comment-section">
        <?php
        // var_dump(isset($_POST['sub'])) ;
        // exit;
        if (isset($_POST['sub']) && !$_POST['comment'] == '') {
            $comment = $_POST["comment"];
            $sqli = "INSERT INTO comment (username, comment) VALUES (:user,'$comment')";
            $query =  $conn->prepare($sqli);
            $usercon = getSession("CurrentCustomerUsername");
            $query->bindParam(':user', $usercon, PDO::PARAM_STR);
            $query->execute();
        }
        // $comment = $_POST["comment"];
        ?>
        <li class="comment user-comment">

            <div class="info">
                <a href="#">فریبا</a>
                <span>22:10:38</span>
            </div>
            <p>سلام چقدر طول میکشه ارسال کنید</p>

        </li>
        <li class="comment author-comment">

            <div class="info">
                <a href="#">مدیر سایت</a>
                <span>3 ساعت پیش</span>
            </div>

            <!-- <a class="avatar" href="#">
                    <img src="images/avatar_author.jpg" width="35" alt="Profile Avatar" title="Jack Smith" />
                </a> -->

            <p>سلام ارسال مشهد 24 ساعت شهرستان 2 تا 3 روز</p>
        </li>


        <?php
        if (isset($_POST["comment"])) {
            # code...
            $sql = "SELECT Id, username, comment, time FROM comment";
            $query =  $conn->prepare($sql);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_OBJ);
            if ($query->rowCount() > 0) {
                foreach ($results as $result) {
        ?>
                    <li class="comment user-comment">

                        <div class="info">
                            <a href="#"><?php echo $result->username; ?></a>
                            <span><?php echo $result->time; ?></span>
                        </div>
                        <p><?php echo $result->comment ?></p>

                    </li>
        <?php }
            }
        }
        ?>
        <li class="write-new">

            <form action="./comAll.php" method="post">

                <textarea placeholder="ارسال دیدگاه" name="comment"></textarea>

                <div>
                    <!-- <img src="images/avatar_user_2.jpg" width="35" alt="Profile of Bradley Jones" title="Bradley Jones" /> -->
                    <input class="sub" type="submit" name="sub" value="ارسال">
                </div>

            </form>

        </li>

    </ul>
</body>

</html>