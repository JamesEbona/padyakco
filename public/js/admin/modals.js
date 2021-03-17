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

function deleteGuide(arg) {
    $('#deleteModal').modal('show');
    var id = $(arg).attr('data-id');
    var href_start = "/admin/guides/delete/";
    var href = href_start + id;

     $("#DeleteUserButton").attr('href', href);
}

function deleteGuideCategory(arg) {
    $('#deleteModal').modal('show');
    var id = $(arg).attr('data-id');
    var href_start = "/admin/guideCategories/delete/";
    var href = href_start + id;

     $("#DeleteCategoryButton").attr('href', href);
}

function deleteInquiry(arg) {
    $('#deleteModal').modal('show');
    var id = $(arg).attr('data-id');
    var href_start = "/admin/inquiries/delete/";
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

function editMechanic(arg) {
    $('#editModal').modal('show');
    var id = $(arg).attr('data-id');
    var first_name = $(arg).attr('data-firstname');
    var last_name = $(arg).attr('data-lastname');
    var phone_number = $(arg).attr('data-phonenumber');
    var email = $(arg).attr('data-email');
    var image = $(arg).attr('data-image');
    var image_start = "/storage/";
    var image_src = image_start + image;

    $("#viewEditImage").attr('src', image_src);
    $("#viewEditImageLink").attr('href', image_src);

    $("#editId").val(id);
    $("#editFirstName").val(first_name);
    $("#editLastName").val(last_name);
    $("#editPhoneNumber").val(phone_number);
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

function editOrder(arg) {
    $('#editModal').modal('show');
    var id = $(arg).attr('data-id');
    var address1 = $(arg).attr('data-address1');
    var address2 = $(arg).attr('data-address2');
    var city = $(arg).attr('data-city');
    var province = $(arg).attr('data-province');
    var postal_code = $(arg).attr('data-postalcode');
    var phone_number = $(arg).attr('data-phonenumber');
   
    $("#editId").val(id);
    $("#editAddress1").val(address1);
    $("#editAddress2").val(address2);
    $("#editCity").val(city);
    document.getElementById('editProvince').value = province; 
    $("#editPostalCode").val(postal_code);
    $("#editPhoneNumber").val(phone_number);
}

function editBooking(arg) {
    $('#editModal').modal('show');
    var id = $(arg).attr('data-id');
    var first_name = $(arg).attr('data-firstname');
    var last_name = $(arg).attr('data-lastname');
    var phone_number = $(arg).attr('data-phonenumber');
    var repair_type = $(arg).attr('data-repairtype');
    var booking_time = $(arg).attr('data-bookingtime');
    var notes = $(arg).attr('data-notes');
    var additional_fee = $(arg).attr('data-additionalfee');
    var status = $(arg).attr('data-status');
   
    $("#editId").val(id);
    $("#editFirstName").val(first_name);
    $("#editLastName").val(last_name);
    $("#editPhoneNumber").val(phone_number);
    $("#editAdditionalFee").val(additional_fee);
    $("#editNotes").val(notes);
    document.getElementById('editRepairType').value = repair_type; 
    $("#editBookingTime").val(booking_time);
    document.getElementById('editStatus').value = status; 
}


function updateStatus(arg) {
    $('#editStatusModal').modal('show');
    var id = $(arg).attr('data-id');
    var status = $(arg).attr('data-status');

    $("#editStatusId").val(id);
    $("#viewId").val(id);
    document.getElementById('editStatus').value = status; 
}

function updateMechanic(arg) {
    $('#editMechanicModal').modal('show');
    var id = $(arg).attr('data-id');
    var mechanic = $(arg).attr('data-mechanic');
    // var additional_fee = $(arg).attr('data-additionalfee');

    $("#viewStatusId").val(id);
    $("#editMechanicId").val(id);

    // $("#editAdditionalFee").val(additional_fee);
    // document.getElementById('editStatus').value = status; 
    if(mechanic){
    document.getElementById('editMechanic').value = mechanic; 
    }
}

function viewAddress(arg) {
    $('#addressModal').modal('show');
    var address1 = $(arg).attr('data-address1');
    var address2 = $(arg).attr('data-address2');
    var city = $(arg).attr('data-city');
    var province = $(arg).attr('data-province');
    var postal_code = $(arg).attr('data-postalcode');
    var phone_number = $(arg).attr('data-phonenumber');
    
    $("#viewAddress1").html(address1);
    $("#viewAddress2").html(address2);
    $("#viewCity").html(city);
    $("#viewProvince").html(province);
    $("#viewPostalCode").html(postal_code);
    $("#viewPhoneNumber").html(phone_number);
}

function viewBooking(arg) {
    $('#viewModal').modal('show');
    var id = $(arg).attr('data-id');
    var status = $(arg).attr('data-status');
    var user_status = $(arg).attr('data-userstatus');
    var first_name = $(arg).attr('data-firstname');
    var last_name = $(arg).attr('data-lastname');
    var phone_number = $(arg).attr('data-phonenumber');
    var location = $(arg).attr('data-location');
    var repair_type = $(arg).attr('data-repairtype');
    var booking_time = $(arg).attr('data-bookingtime');
    var created_at = $(arg).attr('data-createdat');
    var notes = $(arg).attr('data-notes');
    var repair_fee = $(arg).attr('data-repairfee');
    var transportation_fee = $(arg).attr('data-transportationfee');
    var additional_fee = $(arg).attr('data-additionalfee');
    var total_fee = $(arg).attr('data-totalfee');
    var user_image = $(arg).attr('data-userimage');
    var mechanic_name = $(arg).attr('data-mechanicname');
    var mechanic_image = $(arg).attr('data-mechanicimage');
    var mechanic_number = $(arg).attr('data-mechanicnumber');
    var mechanic_status = $(arg).attr('data-mechanicstatus');
    var created_at = $(arg).attr('data-createdat');


    if(status == 'pending'){
    $("#viewBookingStatus").attr("class"," badge badge-pill badge-warning");
    }
    else if(status == 'confirmed'){
    $("#viewBookingStatus").attr("class"," badge badge-pill badge-info");   
    }
    else if(status == 'en route'){
    $("#viewBookingStatus").attr("class"," badge badge-pill badge-primary");   
    }
    else if(status == 'done'){
    $("#viewBookingStatus").attr("class"," badge badge-pill badge-success");   
    }
    else if(status == 'cancelled'){
    $("#viewBookingStatus").attr("class"," badge badge-pill badge-danger");   
    }

    if(user_status == 'active'){
    $("#viewUserStatus").attr("class"," badge badge-pill badge-success");
    }
    else if(status == 'inactive'){
    $("#viewUserStatus").attr("class"," badge badge-pill badge-danger");   
    }

    if(mechanic_status == 'active'){
    $("#viewMechanicStatus").attr("class"," badge badge-pill badge-success");
    }
    else if(mechanic_status == 'inactive'){
    $("#viewMechanicStatus").attr("class"," badge badge-pill badge-danger");   
    }

    // if(additional_fee == 0.00){
    //     addtional_fee = '0.00';
    // }
    
    $("#viewBookingStatus").html(status);
    $("#viewUserStatus").html(user_status);
    $("#viewLocation").html(location);
    $("#viewId").html(id);
    $("#viewCreatedAt").html(created_at);
    $("#viewFirstName").html(first_name);
    $("#viewLastName").html(last_name);
    $("#viewPhoneNumber").html(phone_number);
    $("#viewLocation").html(location);
    $("#viewRepairType").html(repair_type);
    $("#viewBookingTypePayment").html(repair_type);
    $("#viewBookingTime").html(booking_time);
    $("#viewNotes").html(notes);
    $("#viewRepairFee").html(repair_fee);
    $("#viewTransportationFee").html(transportation_fee);
    $("#viewAdditionalFee").html(additional_fee);
    $("#viewTotalFee").html(total_fee);
    $("#viewMechanicName").html(mechanic_name);
    $("#viewMechanicNumber").html(mechanic_number);
    $("#viewMechanicStatus").html(mechanic_status);
    $("#viewCreatedAt").html(created_at);

    var image_start = "/storage/";
    var user_image_src = image_start + user_image;
    var mechanic_image_src = image_start + mechanic_image;
  
    $("#viewUserImage").attr('src', user_image_src);
    $("#viewMechanicImage").attr('src', mechanic_image_src);

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

function viewMessage(arg) {
    $('#messageModal').modal('show');
    var message = $(arg).attr('data-message');
   
    $("#viewMessage").html(message);
}

function replyInquiry(arg) {
    $('#replyInquiryModal').modal('show');
    var id = $(arg).attr('data-id');
    var subject = $(arg).attr('data-subject');
   
    $("#inquiryId").val(id);
    $("#inquirySubject").val(subject);
}
