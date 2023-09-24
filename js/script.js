const customerPanelActiveTabKey = "customerPanelActiveTabIndex";
const localCartKey = "cart";
let storage = localStorage.getItem(localCartKey) ? JSON.parse(localStorage.getItem(localCartKey)) : [];

let Slider = document.querySelector('.search-box-container')
let indexOv = 1
setInterval(()=>{
if (indexOv === 5) {
    indexOv = 1
}else{
    document.querySelector('.search-box-container').style.backgroundImage = 'url("./theme/imgs/'+indexOv+'.png")'
    indexOv++
}
},5000)
function updateBadge() {
    let badgeSpan = document.getElementById("badge");

    while( badgeSpan.firstChild ) {
        badgeSpan.removeChild( badgeSpan.firstChild );
    }
  
    badgeSpan.appendChild(document.createTextNode(storage.length));
}

function isProductExists(productId) {

    for (let i = 0; i < storage.length; i++) {
        if (Number(storage[i].productId) === Number(productId)) {
            return true;
        }
    }
    return false;
}

function updateCartItem(productId, quantity) {

    for (let i = 0; i < storage.length; i++) {
        if (Number(storage[i].productId) === Number(productId) && storage[i].orderQuantity < quantity) {
            storage[i].orderQuantity += 1;
            break;
        }
    }
    localStorage.setItem(localCartKey, JSON.stringify(storage));
}

function addToCart(productId, caption, price, imageUrl, quantity) {

    if (quantity < 1) {
        alert("محصول مورد نظر موجود نیست!");
        return;
    }

    if (isProductExists(productId)) {
        updateCartItem(productId, quantity);
    } else {
        let cartItem = {
            productId: productId,
            caption: caption,
            price: price,
            image: imageUrl,
            orderQuantity: 1,
            productQuantity: quantity
        };

        storage.push(cartItem);
        localStorage.setItem(localCartKey, JSON.stringify(storage));
    }

    updateBadge();
}

// customer panel scripts
function customerPanelSetActiveTabItem(index) {

    const activeItemStyle = "active-item";
    const accountInfoButton = $(".account-info-button");
    const accountInfoSection = $(".account-info");
    const changePasswordButton = $(".change-password-button");
    const changePasswordSection = $(".change-password");
    const ordersButton = $(".orders-button");
    const ordersSection = $(".orders-details");
    const receiptsButton = $(".receipts-button");
    const receiptsSection = $(".receipts-section");

    switch (index) {
        case 1:
            accountInfoButton.addClass(activeItemStyle);
            changePasswordButton.removeClass(activeItemStyle);
            ordersButton.removeClass(activeItemStyle);
            receiptsButton.removeClass(activeItemStyle);

            accountInfoSection.show();
            changePasswordSection.hide();
            ordersSection.hide();
            receiptsSection.hide();
            break;
        case 2:
            changePasswordButton.addClass(activeItemStyle);
            accountInfoButton.removeClass(activeItemStyle);
            ordersButton.removeClass(activeItemStyle);
            receiptsButton.removeClass(activeItemStyle);

            changePasswordSection.show();
            accountInfoSection.hide();
            ordersSection.hide();
            receiptsSection.hide();
            break;

        case 3:
            ordersButton.addClass(activeItemStyle);
            accountInfoButton.removeClass(activeItemStyle);
            changePasswordButton.removeClass(activeItemStyle);
            receiptsButton.removeClass(activeItemStyle);

            ordersSection.show();
            accountInfoSection.hide();
            changePasswordSection.hide();
            receiptsSection.hide();
            break;

        case 4:
            receiptsButton.addClass(activeItemStyle);
            ordersButton.removeClass(activeItemStyle);
            accountInfoButton.removeClass(activeItemStyle);
            changePasswordButton.removeClass(activeItemStyle);

            receiptsSection.show();
            ordersSection.hide();
            accountInfoSection.hide();
            changePasswordSection.hide();
            break;
    }

    setCustomerPanelActiveTabIndex(index);
}

function setCustomerPanelActiveTabIndex(currentIndex) {
    localStorage.setItem(customerPanelActiveTabKey, currentIndex);
}

function getCustomerPanelActiveTabIndex() {
    return localStorage.getItem(customerPanelActiveTabKey) ? Number(localStorage.getItem(customerPanelActiveTabKey)) : 1;
}
// end - customer panel scripts

$(document).ready(function() {
    updateBadge();

    // customer panel scripts
    customerPanelSetActiveTabItem(getCustomerPanelActiveTabIndex());

    $(".customer-panel").on("click", ".account-info-button", function () {
        customerPanelSetActiveTabItem(1);
    });

    $(".customer-panel").on("click", ".change-password-button", function () {
        customerPanelSetActiveTabItem(2);
    });

    $(".customer-panel").on("click", ".orders-button", function () {
        customerPanelSetActiveTabItem(3);
    });

    $(".customer-panel").on("click", ".receipts-button", function () {
        customerPanelSetActiveTabItem(4);
    });

    $(".customer-panel").on("click", ".logout-button", function () {
        let source = document.URL.replace("index.php", "");
        location.href = source + "logout.php?source=" + source;
        localStorage.removeItem(customerPanelActiveTabKey);
    });
    // end - customer panel scripts
});

let loaderElem = document.querySelector('.loader')

window.onload =() => {
    loaderElem.classList.add('hidden') 
}
