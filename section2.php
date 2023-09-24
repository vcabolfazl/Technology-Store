
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
            <h2><?php echo PRODUCTS_LIST; ?></h2>
        </section>

        <!-- products grid list -->
        <section class="main-content">

        <div class="card"><a href="http://127.0.0.1/shop/product-details.php?id=67" class="item-link"><img src="http://127.0.0.1/shop/products/4442.webp"><h1>مجموعه کنسول بازی سونی مدل PlayStation 5 Drive ظرفیت 825 گیگابایت </h1><p class="price">41800000</p></a><button class="secondary-button" onclick="addToCart(67, 'مجموعه کنسول بازی سونی مدل PlayStation 5 Drive ظرفیت 825 گیگابایت ', 41800000, 'http://127.0.0.1/shop/products/4442.webp', 1)">افزودن به سبد</button></div>               
            
        </section>
<?php require_once("footer.php"); ?>