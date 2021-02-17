$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


$(document).ready(function () {
   
function fetch_data(page, bicycle_type, brand, price)
 {
  $.ajax({
   url:"/search/fetch_data?page="+page+"&bicycle_type="+bicycle_type+"&brand="+brand+"&price="+price,
   success:function(data)
   {
    $('.products_data').html('');
    $('.products_data').html(data);
   }
  })
 }

  $(document).on('click', 'input[data-js="subcategory_filter"]', function(){
var help_cash;
var help_food;
var help_ppe;
var help_materials;

if($('input[name="help_cash"]').is(':checked')){
  help_cash = "1";
} 
else {
  help_cash = "0";
}
if($('input[name="help_food"]').is(':checked')){
  help_food = "1";
} 
else {
  help_food = "0";
}
if($('input[name="help_ppe"]').is(':checked')){
  help_ppe = "1";
} 
else {
  help_ppe = "0";
}
if($('input[name="help_materials"]').is(':checked')){
  help_materials = "1";
} 
else {
  help_materials = "0";
}

var page = '1';
$('#hidden_page').val(page);
var query = $('#location').val();

$('#hidden_help_cash').val(help_cash);
$('#hidden_help_food').val(help_food);
$('#hidden_help_ppe').val(help_ppe);
$('#hidden_help_materials').val(help_materials);

fetch_data(page, help_cash, help_food, help_ppe, help_materials, query);

});    


 $(document).on('click', '.pagination a', function(event){
  event.preventDefault();
  var page = $(this).attr('href').split('page=')[1];
  $('#hidden_page').val(page);
  var help_cash = $('#hidden_help_cash').val();
  var help_food = $('#hidden_help_food').val();
  var help_ppe = $('#hidden_help_ppe').val();
  var help_materials = $('#hidden_help_materials').val();
  var query = $('#location').val();

  $('li').removeClass('active');
        $(this).parent().addClass('active');

  fetch_data(page, help_cash, help_food, help_ppe, help_materials, query);
 });


 

//Call function when checkbox is clicked
// $("input[type='checkbox']").on( "click", showOrganizations );

//Remove checked when checkbox is checked
// $(".checkboxes").click(function(){
  //  $(this).removeAttr('checked');      
  //  showOrganizations();
// });




});