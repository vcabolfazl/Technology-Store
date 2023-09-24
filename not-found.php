<?php 
    require_once("core/resources.php"); 
    require_once("core/utilities.php"); 

    setPageTitle(NOT_FOUND_TITLE);
    
    require_once("header.php"); 
?>

<section class="not-found">
    <div class="not-found-error-code">
        <span>404</span>
    </div>

    <p class="description"><?php echo NOT_FOUND_MESSAGE; ?></p>

    <div class="options">
        <div class="search-box">
            <form action="search.php" method="GET">
                <input type="search" placeholder="<?php echo SEARCH; ?>" name="keyword" class="text-box">
                <button><i class="fa fa-search fa-lg"></i></button>
            </form>
        </div>

        <p><?php echo OR_WORD; ?></p>  

        <a href="<?php echo HOME_PAGE_URL; ?>"><?php echo BACK_TO_HOME; ?></a>
              
    </div>
</section>

<?php require_once("footer.php"); ?>