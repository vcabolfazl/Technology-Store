<?php 
    require_once("core/product-manager.php");
    require_once("core/resources.php");
    require_once("core/utilities.php");

    setPageTitle(SEARCH_TITLE);

    if (isset($_GET['keyword']))
        $keyword = $_GET['keyword'];
    else 
        $keyword = "";

    require_once("header.php");

    
    $productManager = new ProductManager();
    $searchResult = $productManager->search($keyword);
    $resultCounter = count($searchResult);
?>

<section class="search-page">

    <div class="search-box">
        <form action="search.php" method="GET">
            <input type="search" placeholder="<?php echo SEARCH; ?>" name="keyword" class="text-box" value="<?php echo $keyword; ?>">
            <button><i class="fa fa-search fa-lg"></i></button>
        </form>        
    </div>

    <div class="search-result">
        <span><?php echo SEARCH_RESULT.' ( '.$resultCounter.' )'; ?></span>
    </div>

    <!-- products grid list -->
    <section class="main-content" style="height:100%;">        

    <?php      
        foreach($searchResult as &$product) {
            $addToCartArgs = $product["product_id"].', \''.$product['caption'].'\', '.$product['price'].', \''.$product['image_url'].'\', '.$product['quantity'];
            $isProductAvailable = intval($product["quantity"]) > 0;
            $buttonStatus = $isProductAvailable ? '' : 'disabled';

            echo '<div class="card">';

            if (!$isProductAvailable) {
                echo '<span class="quantity-status-label">ناموجود</span>';
            }
            echo '<a href="'.BASE_URL.'product-details.php?id='.$product["product_id"].'" class="item-link">';
            echo '<img src="'.$product["image_url"].'">';
            echo '<h1>'.$product["caption"].'</h1>';
            echo '<p class="price">'.$product["price"].'</p> ';
            echo '</a>';
            echo '<button class="secondary-button" '.$buttonStatus.' onClick="addToCart('.$addToCartArgs.')">'.ADD_TO_BASKET.'</button>';
            echo '</div>';
        }

        if ($resultCounter < 1) {
            echo '<h3>موردی یافت نشد!</h3>';
        }
    ?>  

    </section>
</section>
<?php require_once("footer.php"); ?>