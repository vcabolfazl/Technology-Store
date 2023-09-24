/**
 * delete specified product
 * @param {*} deleteUrl The product delete url
 */
function deleteProduct(deleteUrl) {
    var alertMessage = "حذف محصول انتخاب شده؟";
    var confirmResult = confirm(alertMessage);

    if (confirmResult == false) {
        return;
    } 

    window.location = deleteUrl;
}

/**
 * delete specified customer
 * @param {*} deleteUrl The customer delete url
 */
function deleteCustomer(deleteUrl) {
    var alertMessage = "حذف مشتری انتخاب شده؟";
    var confirmResult = confirm(alertMessage);

    if (confirmResult == false) {
        return;
    } 

    window.location = deleteUrl;
}

/**
 * delete specified user
 * @param {*} deleteUrl The user delete url
 */
function deleteUser(deleteUrl) {
    var alertMessage = "حذف کاربر انتخاب شده؟";
    var confirmResult = confirm(alertMessage);

    if (confirmResult == false) {
        return;
    } 

    window.location = deleteUrl;
}

/**
 * return the selected image url in file input
 * @param {*} input The file dialog input
 */
function readUrl(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            $('.image-preview').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

/**
 *  jQuery scripts
 */
$(document).ready(function() {
    // products add/edit section image selector change event handler
    $('.product-image-selector').change(function(e){ readUrl(this); });
});