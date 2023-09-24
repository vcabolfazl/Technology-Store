<div class="loader">
    <img src="./theme/imgs/loading.gif" alt="Loading..." />
</div>
<?php
require_once("core/product-manager.php");
require_once("core/utilities.php");
require_once("core/resources.php");

setPageTitle(PRODUCT_DETAILS_TITLE);

// get current product id to loading information
$productId = intval($_GET['id']);

// display not found page
if ($productId == 0) {
    redirectTo(NOT_FOUND_PAGE_URL);
}

require_once("header.php");

$productManager = new ProductManager();
$productInfo = $productManager->getById($productId);
$productIsAvailable = intval($productInfo->quantity) > 0;
$productQuantityClass = $productIsAvailable ? "available-product" : "unavailable-product";

// display not found page
if ($productInfo->productId <= 0) {
    redirectTo(NOT_FOUND_PAGE_URL);
}

$addToCartArgs = $productInfo->productId . ', \'' . $productInfo->caption . '\', ' . $productInfo->price . ', \'' . $productInfo->imageUrl . '\', ' . $productInfo->quantity;

?>

<section class="product-details">

    <!-- caption and description -->
    <div class="right-side card">
        <!-- caption -->
        <h1><?php echo $productInfo->caption; ?></h1>

        <!-- description -->
        <p><?php echo $productInfo->description; ?></p>
    </div>

    <!-- product image and price -->
    <div class="left-side">
        <div class="product-info card">
            <!-- image -->
            <img src="<?php echo $productInfo->imageUrl; ?>">

            <!-- price -->
            <p class="price"><?php echo $productInfo->price; ?></p>

            <!-- add to chart button -->
            <button class="secondary-button" <?php echo intval($productInfo->quantity) > 0 ? "" : "disabled"; ?> onclick="addToCart(<?php echo $addToCartArgs; ?>)"><?php echo ADD_TO_BASKET; ?></button>
        </div>

        <div class="date-quantity card">
            <!-- status -->
            <p class="<?php echo $productQuantityClass; ?>"><?php echo intval($productInfo->quantity) > 0 ? "موجود" : "ناموجود"; ?> <span> ( <?php echo intval($productInfo->quantity); ?> ) </span></p>

            <!-- reg data time -->
            <p class="date"><?php echo $productInfo->regDate; ?></p>
        </div>
    </div>


</section>

<?php require_once("footer.php"); ?>