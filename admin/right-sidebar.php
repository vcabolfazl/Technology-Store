<?php 
    require_once("header.php");

    $activeSection = NULL;

    if (isset($_GET["section"])) {
        $activeSection = $_GET["section"];
    } else {
        $activeSection = 0;
    }
?>

<script>

    function setActiveTabItem(index) {
        let activeSection = index;
        let activeSectionStyleClass = "active-section";
        let productsSection = $(".products-section");
        let customersSection = $(".customers-section");
        let usersSection = $(".users-section");
        let ordersSection = $(".orders-section");

        switch (activeSection) {
            case 0:
                productsSection.addClass(activeSectionStyleClass);
                customersSection.removeClass(activeSectionStyleClass);
                usersSection.removeClass(activeSectionStyleClass);
                ordersSection.removeClass(activeSectionStyleClass);
                break;
            case 1:
                productsSection.removeClass(activeSectionStyleClass);
                customersSection.addClass(activeSectionStyleClass);
                usersSection.removeClass(activeSectionStyleClass);
                ordersSection.removeClass(activeSectionStyleClass);
                break;
            case 2:
                productsSection.removeClass(activeSectionStyleClass);
                customersSection.removeClass(activeSectionStyleClass);
                usersSection.addClass(activeSectionStyleClass);
                ordersSection.removeClass(activeSectionStyleClass);
                break;
            case 3:
                productsSection.removeClass(activeSectionStyleClass);
                customersSection.removeClass(activeSectionStyleClass);
                usersSection.removeClass(activeSectionStyleClass);
                ordersSection.addClass(activeSectionStyleClass);
                break;
        }
    }

    $(document).ready(function () {
        let index = Number(<?php echo $activeSection; ?>);
        setActiveTabItem(index);
    });
</script>

<section class="right-sidebar">
    <a href="<?php echo CONTROL_PANEL_URL.'?section=0'?>" class="products-section"><button class="secondary-button"><?php echo MANAGE_PRODUCTS; ?></button></a>
    <a href="<?php echo CONTROL_PANEL_URL.'?section=1'?>" class="customers-section"><button class="secondary-button"><?php echo MANAGE_CUSTOMERS; ?></button></a>
    <a href="<?php echo CONTROL_PANEL_URL.'?section=2'?>" class="users-section"><button class="secondary-button"><?php echo MANAGE_USERS; ?></button></a>
    <a href="<?php echo CONTROL_PANEL_URL.'?section=3'?>" class="orders-section"><button class="secondary-button"><?php echo ORDERS; ?></button></a>
    <a href="<?php echo HOME_PAGE_URL; ?>" target="_blank"><button class="secondary-button"><?php echo SHOW_SITE; ?></button></a>
    <a href="<?php echo CONTROL_PANEL_LOGOUT_URL; ?>"><button class="secondary-button"><?php echo LOGOUT; ?></button></a>
</section>