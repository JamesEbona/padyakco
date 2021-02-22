function addRow() {
    $('#addModal').modal('show');
}

function deleteUser(arg) {
    $('#deleteModal').modal('show');
    var id = $(arg).attr('data-id');
    var href_start = "/admin/users/delete/";
    var href = href_start + id;

     $("#DeleteUserButton").attr('href', href);
}

function deleteCategory(arg) {
    $('#deleteModal').modal('show');
    var id = $(arg).attr('data-id');
    var href_start = "/admin/categories/delete/";
    var href = href_start + id;

     $("#DeleteCategoryButton").attr('href', href);
}

function deleteSubCategory(arg) {
    $('#deleteModal').modal('show');
    var id = $(arg).attr('data-id');
    var href_start = "/admin/subcategories/delete/";
    var href = href_start + id;

     $("#DeleteSubCategoryButton").attr('href', href);
}

function deleteProduct(arg) {
    $('#deleteModal').modal('show');
    var id = $(arg).attr('data-id');
    var href_start = "/admin/products/delete/";
    var href = href_start + id;

     $("#DeleteUserButton").attr('href', href);
}

function editUser(arg) {
    $('#editModal').modal('show');
    var id = $(arg).attr('data-id');
    var first_name = $(arg).attr('data-firstname');
    var last_name = $(arg).attr('data-lastname');
    var email = $(arg).attr('data-email');
    var image = $(arg).attr('data-image');
    var image_start = "/storage/";
    var image_src = image_start + image;

    $("#viewEditImage").attr('src', image_src);
    $("#viewEditImageLink").attr('href', image_src);

    $("#editId").val(id);
    $("#editFirstName").val(first_name);
    $("#editLastName").val(last_name);
    $("#editEmail").val(email);
}

function editProduct(arg) {
    $('#editModal').modal('show');
    var id = $(arg).attr('data-id');
    var title = $(arg).attr('data-title');
    var brand = $(arg).attr('data-brand');
    var category_id = $(arg).attr('data-category_id');
    var subcategory_id = $(arg).attr('data-subcategory_id');
    var quantity = $(arg).attr('data-quantity');
    var price = $(arg).attr('data-price');
    var delivery_fee = $(arg).attr('data-delivery');
    var provincial_delivery_fee = $(arg).attr('data-provincial');
    var price = $(arg).attr('data-price');
    var description = $(arg).attr('data-description');
    var image1 = $(arg).attr('data-image1');
    var image2 = $(arg).attr('data-image2');
    var image3 = $(arg).attr('data-image3');
    var image_start = "/storage/";
    var image_src1 = image_start + image1;
    var image_src2 = image_start + image2;
    var image_src3 = image_start + image3;

    $("#editImage1").attr('src', image_src1);
    $("#editImage2").attr('src', image_src2);
    $("#editImage3").attr('src', image_src3);
    // $("#viewEditImageLink").attr('href', image_src);

    $("#editId").val(id);
    $("#editTitle").val(title);
    $("#editBrand").val(brand);
    $("#editCategoryId").val(category_id);
    $("#editSubCategoryId").val(subcategory_id);
    $("#editQuantity").val(quantity);
    $("#editPrice").val(price);
    $("#editDelivery").val(delivery_fee);
    $("#editProvincial").val(provincial_delivery_fee);
    $("#editDescription").val(description);
    document.getElementById('category_id').value = category_id; 
    document.getElementById('subcategory_id').value = subcategory_id; 
}

function editCategory(arg) {
    $('#editModal').modal('show');
    var id = $(arg).attr('data-id');
    var title = $(arg).attr('data-title');
    var description = $(arg).attr('data-description');
   
    $("#editId").val(id);
    $("#editTitle").val(title);
    $("#editDescription").val(description);
}

function editSubCategory(arg) {
    $('#editModal').modal('show');
    var id = $(arg).attr('data-id');
    var title = $(arg).attr('data-title');
    var description = $(arg).attr('data-description');
    var category = $(arg).attr('data-category');
   
    $("#editId").val(id);
    $("#editTitle").val(title);
    $("#editDescription").val(description);
    document.getElementById('category_id').value = category; 
}

function viewAddress(arg) {
    $('#addressModal').modal('show');
    var address1 = $(arg).attr('data-address1');
    var address2 = $(arg).attr('data-address2');
    var city = $(arg).attr('data-city');
    var province = $(arg).attr('data-province');
    var postal_code = $(arg).attr('data-postalcode');
    var phone_number = $(arg).attr('data-phonenumber');
    
    $("#viewAddress1").val(address1);
    $("#viewAddress2").val(address2);
    $("#viewCity").val(city);
    $("#viewProvince").val(province);
    $("#viewPostalCode").val(postal_code);
    $("#viewPhoneNumber").val(phone_number);
}

function viewUserPicture(arg) {
    $('#viewModal').modal('show');
    var image = $(arg).attr('data-image');
    var image_start = "/storage/";
    var image_src = image_start + image;

    $("#viewImage").attr('src', image_src);
    $("#viewImageLink").attr('href', image_src);
}

function viewProductPicture(arg) {
    $('#viewModal').modal('show');
    var image1 = $(arg).attr('data-image1');
    var image2 = $(arg).attr('data-image2');
    var image3 = $(arg).attr('data-image3');
    var image_start = "/storage/";
    var image_src1 = image_start + image1;
    var image_src2 = image_start + image2;
    var image_src3 = image_start + image3;

    $("#viewImage1").attr('src', image_src1);
    $("#viewImage2").attr('src', image_src2);
    $("#viewImage3").attr('src', image_src3);
}

$('.crud').on('hidden.bs.modal', function () {
    $('.modal-errors').hide(); 
})    