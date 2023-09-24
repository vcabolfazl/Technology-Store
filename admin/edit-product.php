<?php 
    require_once("../core/resources.php");
    require_once("../core/utilities.php");
    require_once("../core/product-manager.php");

    setPageTitle(EDIT_PRODUCT_TITLE);

    $actionMessages = ALT_255;
    $productManager = new ProductManager();
    $productId = 0;

    if (isset($_GET["pid"]))
        $productId = intval($_GET["pid"]);

    if ($productId < 1) {
        redirectTo(ERROR_PAGE_URL);
        return;
    }
    $productInfo = $productManager->getById($productId);

    if ($productInfo->productId == NULL) {
        redirectTo(ERROR_PAGE_URL."?code=1001");
    }

    if (isset($_POST["submit"])) {

        $productImage = NULL;

        if (empty($_FILES['image']['name'])) {
            $productImage = $productInfo->imageUrl;
        } else {

            $imageLocalPath = convertImageUrlToPath($productInfo->imageUrl);
            if (file_exists($imageLocalPath))
                unlink($imageLocalPath);

            $fileExtension = strtolower(pathinfo($_FILES['image']['name'],PATHINFO_EXTENSION));
            $filename = pathinfo($_FILES['image']['name'], PATHINFO_FILENAME).'.'.$fileExtension;
            $uploadPath = PRODUCTS_IMAGES_PATH.$filename;
    
            move_uploaded_file($_FILES["image"]['tmp_name'], $uploadPath);

            $productImage = PRODUCTS_IMAGES_URL.$filename;
        }

        try {
            $date = new DateTime("now", new DateTimeZone('Asia/Tehran'));
        } catch (Exception $e) {
        }

        $productInfo->caption = $_POST["caption"];
        $productInfo->description = $_POST["description"];
        $productInfo->price = $_POST["price"];
        $productInfo->quantity = $_POST["quantity"];
        $productInfo->regDate = $date->format('Y-m-d H:i:s');
        $productInfo->imageUrl = $productImage;
        $productInfo->categories = $_POST["categories"];

        if ($productManager->update($productInfo))
            $actionMessages = EDIT_PRODUCT_SUCCESS_MESSAGE;
        else 
            $actionMessages = EDIT_PRODUCT_FAILED_MESSAGE;
    }

    require_once("header.php"); 
?>

<section class="add-new-product">
    
    <h1><?php echo EDIT_PRODUCT; ?></h1>

    <section class="message">
        <p><?php echo $actionMessages ?></p>
    </section>

    <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST" class="add-form" enctype="multipart/form-data">

        <!-- title section -->
        <div class="product-caption">
            <input type="text" name="caption" class="text-box caption" placeholder="<?php echo CAPTION; ?>" value="<?php echo $productInfo->caption; ?>">
            <input type="text" name="price" class="text-box" placeholder="<?php echo UNIT_PRICE; ?>" value="<?php echo $productInfo->price; ?>">
            <input type="text" name="quantity" class="text-box" placeholder="<?php echo QUANTITY; ?>" value="<?php echo $productInfo->quantity; ?>">
            <select name="categories" id="" class="text-box">
                <option value="لپ تاپ "> لپ تاپ </option>
                <option value="کیس کامپیوتر "> کیس کامپیوتر </option>
                <option value="لپ تاپ"> لپ تاپ </option>
                <option value="کنسول خانگی "> کنسول خانگی </option>
                <option value="لوازم جانبی ">  لوازم جانبی </option>
            </select>
        </div>

        <section class="description-and-image">
        
            <!-- editor section -->
            <textarea id="add-product-editor" class="description" name="description">
                <?php echo $productInfo->description; ?>
            </textarea>

            <script>
                CKEDITOR.replace('add-product-editor', {
                    contentsLangDirection: 'rtl',
                    font_defaultLabel: 'Tahoma',
                    fontSize_defaultLabel: '20',
                    height: 400,
                    width: 800
                });
            </script>

            <!-- image section -->
            <div class="image">
                <img src="<?php echo $productInfo->imageUrl; ?>" class="image-preview">
                <br>
                <input type="file" name="image" class="product-image-selector">
            </div>
        
        </section>

        <!-- add button section -->
        <div class="add-button">
            <button class="primary-button" type="submit" name="submit"><?php echo EDIT; ?></button>
        </div>   
    </form>
</section>