<?php 
    require_once("../core/resources.php");
    require_once("../core/utilities.php");
    require_once("../core/user-manager.php");

    if (isset($_POST['keyword']))
        $keyword = $_POST['keyword'];
    else 
        $keyword = NULL;

    $actionMessages = ALT_255;
    $userManager = new UserManager();

    if ($keyword != NULL)
        $users = $userManager->search($keyword);
    else 
        $users = $userManager->getAll();

    if (isset($_GET["action"]) && $_GET["action"] == "delete") {
        if (isset($_GET["uid"])) {
            $userId = intval($_GET["uid"]);
            if ($userId > 0) {
                
                if ($userManager->delete($userId))
                    redirectTo(CONTROL_PANEL_URL.'?section='.$activeSection.'&result=1');
                else 
                    redirectTo(CONTROL_PANEL_URL.'?section='.$activeSection.'&result=0');
            }
            
        }
     }

     if (isset($_GET["result"])) {
         
        if ($_GET["result"] == 1) {
            $actionMessages = SUCCESS_DELETE_MESSAGE;
        } else  {
            $actionMessages = FAILED_DELETE_MESSAGE;
        }
     } 

     setPageTitle(MANAGE_USERS_TITLE);
     require_once("header.php"); 
    
?>

<section class="users">

    <section class="caption">
        <h4><?php echo USERS_LIST; ?></h4>
    </section>

    <section class="message">
        <p><?php echo $actionMessages ?></p>
    </section>

    <section class="toolbar">
        <div class="add-button">
            <a href="<?php echo ADD_NEW_USER_URL.'?section=2'; ?>"><button class="primary-button"><?php echo ADD_NEW_USER; ?></button></a>
        </div>

        <div class="search-box">
            <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST">
                <input type="search" placeholder="<?php echo SEARCH; ?>" name="keyword" class="text-box" value="<?php echo $keyword; ?>">
                <button><i class="fa fa-search fa-lg"></i></button>
            </form>     
        </div>    
    </section>

    <section class="list">
        <table> 
            <!-- headers -->
            <tr>
                <th><?php echo INDEX; ?></th>
                <th><?php echo EDIT; ?></th>
                <th><?php echo DELETE; ?></th>
                <th><?php echo FULL_NAME; ?></th>
                <th><?php echo USERNAME; ?></th>
                <th><?php echo PASSWORD; ?></th>
            </tr>

            <!-- contents -->
            <?php 
                $index = 1;

                // create items
                foreach($users as &$user) {     

                    $deleteUrl = CONTROL_PANEL_URL."?section=".$activeSection."&uid=".$user['user_id']."&action=delete";
                    $editUrl = EDIT_USER_URL."?section=".$activeSection."&uid=".$user["user_id"];

                    echo '<tr>';           
                    echo '<td>'.$index++.'</td>';
                    echo '<td><a href="'.$editUrl.'" title="'.EDIT.'"><button class="action-button"><i class="fas fa-pencil-alt"></i></button></a></td>';
                    echo '<td><button class="action-button" onClick="deleteUser(\''.$deleteUrl.'\')"><i class="fas fa-trash-alt"></i></button></td>';
                    echo '<td>'.$user['full_name'].'</td>';
                    echo '<td>'.$user['username'].'</td>';
                    echo '<td>...</td>';
                    echo '</tr>';     
                }
            ?>
        </table>
    </section>
    
</section>
