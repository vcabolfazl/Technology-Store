<?php 
     require_once("core/product-manager.php");
     require_once("core/resources.php");
     require_once("core/utilities.php");

     setPageTitle(SITE_TITLE);

     $productManager = new ProductManager();
     $products = $productManager->getAll();
     $productsCount = count($products);
?>
    <div class="loader">
      <img src="./theme/imgs/loading.gif" alt="Loading..." />
    </div>

<?php require_once("header.php"); ?>
        <!-- search box section -->
        <section class="search-box-container">
            <div class="search-box">
                <form action="search.php" method="GET">
                    <input type="search" placeholder="<?php echo SEARCH; ?>" name="keyword" class="text-box">
                    <button><i class="fa fa-search fa-lg"></i></button>
                </form>
            </div>
        </section>

        <!-- caption -->
        <section class="main-content-caption">
            <h2><?php echo PRODUCTS_LIST;?></h2>
        </section>

        <!-- products grid list -->
        <section class="main-content">

        <?php
        if (isset($_GET['section']) == 1) {
            echo '<div class="card"><span class="quantity-status-label">ناموجود</span><a href="http://127.0.0.1/shop/product-details.php?id=70" class="item-link"><img src="http://127.0.0.1/shop/products/9600.webp"><h1>کیس کامپیوتر مدل GrayMatte</h1><p class="price">9600000</p></a><button class="secondary-button" disabled="" onclick="addToCart(70,"کیس کامپیوتر مدل GrayMatte", 9600000, "http://127.0.0.1/shop/products/9600.webp">افزودن به سبد</button></div>';
        } elseif(isset($_GET['section']) == 2){
        }elseif(isset($_GET['section']) == 3){
            echo "<script>alert('333')</script>";

        }elseif(isset($_GET['section']) == 4){
            echo "<script>alert('444')</script>";

        }else{
            // create items
            foreach($products as &$product) {     
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
                echo '<p class="price">'.$product["price"].'</p>';
                echo '</a>';
                echo '<button class="secondary-button" '.$buttonStatus.' onClick="addToCart('.$addToCartArgs.')">'.ADD_TO_BASKET.'</button>';
                echo '</div>';
            }}
        ?>       
            
        </section>
<?php require_once("comment.php")?>
<?php require_once("footer.php"); ?>