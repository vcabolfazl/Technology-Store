<?php 
    require_once("../core/resources.php");
    require_once("../core/utilities.php");
    require_once("../core/product-manager.php");

    setPageTitle(ADD_PRODUCT_TITLE);

    require_once("header.php"); 
    
    $actionMessages = ALT_255;
    $productManager = new ProductManager();

    if (isset($_POST["submit"])) {

        $fileExtension = strtolower(pathinfo($_FILES['image']['name'],PATHINFO_EXTENSION));
        $filename = pathinfo($_FILES['image']['name'], PATHINFO_FILENAME).'.'.$fileExtension;
        $uploadPath = PRODUCTS_IMAGES_PATH.$filename;

        move_uploaded_file($_FILES["image"]['tmp_name'], $uploadPath);


        try {
            $date = new DateTime("now", new DateTimeZone('Asia/Tehran'));
        } catch (Exception $e) {
        }

        $productInfo = new Product();
        $productInfo->caption = $_POST["caption"];
        $productInfo->description = $_POST["description"];
        $productInfo->price = $_POST["price"];
        $productInfo->quantity = $_POST["quantity"];
        $productInfo->regDate = $date->format('Y-m-d H:i:s');
        $productInfo->imageUrl = PRODUCTS_IMAGES_URL.$filename;


        if ($productManager->add($productInfo))
            $actionMessages = ADD_PRODUCT_SUCCESS_MESSAGE;
        else 
            $actionMessages = ADD_PRODUCT_FAILED_MESSAGE;
    }
?>

<section class="add-new-product">
    
<h1><?php echo ADD_NEW_PRODUCT; ?></h1>

    <section class="message">
        <p><?php echo $actionMessages ?></p>
    </section>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="add-form" enctype="multipart/form-data">

        <!-- title section -->
        <div class="product-caption">
            <input type="text" name="caption" class="text-box caption" placeholder="عنوان محصول">
            <input type="text" name="price" class="text-box" placeholder="قیمت">
            <input type="text" name="quantity" class="text-box" placeholder="تعداد">
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
            <textarea id="add-product-editor" class="description" name="description" placeholder="<?php echo PRODUCT_DESCRIPTION; ?>">
                
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
                <img src="<?php echo DEFAULT_IMAGE; ?>" class="image-preview">
                <br>
                <input type="file" name="image" class="product-image-selector">
            </div>
        
        </section>

        <!-- add button section -->
        <div class="add-button">
            <button class="primary-button" type="submit" name="submit"><?php echo SUBMIT; ?></button>
        </div>   
    </form>
</section>