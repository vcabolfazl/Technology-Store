<?php 
    require_once("../core/resources.php");
    require_once("../core/utilities.php");
    require_once("../core/customer-manager.php");


    if (isset($_POST['keyword']))
        $keyword = $_POST['keyword'];
    else 
        $keyword = NULL;

    $actionMessages = ALT_255;
    $customerManager = new CustomerManager();

    if ($keyword != NULL)
        $customers = $customerManager->search($keyword);
    else 
        $customers = $customerManager->getAll();

    if (isset($_GET["action"]) && $_GET["action"] == "delete") {
        if (isset($_GET["cid"])) {
            $customerId = intval($_GET["cid"]);
            if ($customerId > 0) {
                
                if ($customerManager->delete($customerId))
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

    setPageTitle(MANAGE_CUSTOMERS_TITLE);
    require_once("header.php");    
?>

<section class="customers">

    <section class="caption">
        <h4><?php echo CUSTOMERS_LIST; ?></h4>
    </section>

    <section class="message">
        <p><?php echo $actionMessages ?></p>
    </section>

    <section class="toolbar">
        <div class="add-button">
            <a href="<?php echo ADD_NEW_CUSTOMER_URL.'?section=1'; ?>"><button class="primary-button"><?php echo ADD_NEW_CUSTOMER; ?></button></a>
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
                <th><?php echo PHONE; ?></th>
                <th><?php echo ADDRESS; ?></th>
                <th><?php echo Date; ?></th>
            </tr>

            <!-- contents -->
            <?php 
                $index = 1;

                // create items
                foreach($customers as &$customer) {     

                    $deleteUrl = CONTROL_PANEL_URL."?section=".$activeSection."&cid=".$customer['customer_id']."&action=delete";
                    $editUrl = EDIT_CUSTOMER_URL."?section=".$activeSection."&cid=".$customer["customer_id"];

                    echo '<tr>';           
                    echo '<td>'.$index++.'</td>';
                    echo '<td><a href="'.$editUrl.'" title="'.EDIT.'"><button class="action-button"><i class="fas fa-pencil-alt"></i></button></a></td>';
                    echo '<td><button class="action-button" onClick="deleteCustomer(\''.$deleteUrl.'\')"><i class="fas fa-trash-alt"></i></button></td>';
                    echo '<td>'.$customer['full_name'].'</td>';
                    echo '<td>'.$customer['username'].'</td>';
                    echo '<td>&#127820;</td>';
                    echo '<td>'.$customer['phone'].'</td>';
                    echo '<td>'.$customer['address'].'</td>';
                    echo '<td>'.$customer['Date'].'</td>';
                    echo '</tr>';     
                }
            ?>
        </table>
    </section>
    
</section>
