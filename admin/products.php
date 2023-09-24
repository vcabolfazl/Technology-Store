<?php 
    require_once("../core/resources.php");
    require_once("../core/utilities.php");
    require_once("../core/product-manager.php");

    setPageTitle(MANAGE_PRODUCTS_TITLE);

    if (isset($_POST['keyword']))
        $keyword = $_POST['keyword'];
    else 
        $keyword = NULL;

    require_once("header.php"); 

    $actionMessages = ALT_255;
    $productManager = new ProductManager();

    if ($keyword != NULL)
        $products = $productManager->search($keyword);
    else 
        $products = $productManager->getAll();

    if (isset($_GET["action"]) && $_GET["action"] == "delete") {
        if (isset($_GET["pid"])) {
            $productId = intval($_GET["pid"]);
            if ($productId > 0) {
                
                $productInfo = $productManager->getById($productId);
                $imageLocalPath = convertImageUrlToPath($productInfo->imageUrl);
                unlink($imageLocalPath);

                if ($productManager->delete($productId))
                    redirectTo(CONTROL_PANEL_URL.'?section='.$activeSection.'&result=1');
                else 
                    redirectTo(CONTROL_PANEL_URL.'?section='.$activeSection.'&result=0');
            }
            
        }
     }

     if (isset($_GET["result"])) {
         
        if ($_GET["result"] == 1) {
            $actionMessages = SUCCESSFUL_DELETE_MESSAGE;
         } else  {
            $actionMessages = FAILURE_DELETE_MESSAGE;
         }
     } 
    
?>

<section class="products">

    <section class="caption">
        <h4><?php echo PRODUCTS_LIST; ?></h4>
    </section>

    <section class="message">
        <p><?php echo $actionMessages ?></p>
    </section>

    <section class="toolbar">
        <div class="add-button">
            <a href="<?php echo ADD_NEW_PRODUCT_URL.'?section=0'; ?>"><button class="primary-button"><?php echo ADD_NEW_PRODUCT; ?></button></a>
        </div>

        <div class="search-box">
            <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST">
                <input type="search" placeholder="<?php echo SEARCH; ?>" name="keyword" class="text-box" value="<?php echo $keyword; ?>">
                <button><i class="fa fa-search fa-lg"></i></button>
            </form>     
        </div>    
    </section>

    <section class="list">

    <?php 
        // create items
        foreach($products as &$product) {                
            echo '<div class="card">';
            echo '<img src="'.$product["image_url"].'">';
            echo '<h1>'.$product["caption"].'</h1>';
            
            echo '<div class="price-and-date">';
            echo '<span class="price">'.$product["price"].'</span>';
            echo '<span class="date">'.$product["reg_date"].'</span>';
            echo '</div>'; 

            $deleteUrl = CONTROL_PANEL_URL."?section=".$activeSection."&pid=".$product['product_id']."&action=delete";
            $editUrl = EDIT_PRODUCT_URL.'?pid='.$product["product_id"];

            echo '<a href="'.$editUrl.'" title="'.EDIT.'"><button class="action-button"><i class="fas fa-pencil-alt"></i></button></a>';
            echo '<button class="action-button" onClick="deleteProduct(\''.$deleteUrl.'\')"><i class="fas fa-trash-alt"></i></button>';
            echo '<a href="'.BASE_URL.'product-details.php?id='.$product["product_id"].'" target="_blank" title="'.SHOW.'"><button class="action-button"><i class="fas fa-tv"></i></button></a>';
            echo '</div>';
        }
    ?>
    </section>
    
</section>
