jQuery(document).ready(function($) {
/*------------ Validation Function-----------------*/
$(".final_submit").click(function(event) {
var radio_check = $('.radio-input input[name="radio_Indique-proyecto"]'); // Fetching Radio Button By Class Name
var input_field = $('input'); // Fetching All Inputs With Same Class Name text_field & An HTML Tag textarea
var text_area = $('textarea');
var fieldset = $('fieldset');
alert('Sus datos se han enviado correctamente..');

});
	 jQuery('input[type="checkbox"]').click(function(){
            if(jQuery(this).prop("checked") == true){
                jQuery(this).attr("checked", "checked");
            }
            else if(jQuery(this).prop("checked") == false){
               jQuery(this).removeAttr("checked", "checked");
            }
        });

	jQuery('input[type="radio"]').click(function(){
            if(jQuery(this).prop("checked") == true){
                jQuery(this).attr("checked", "checked");
            }
            else if(jQuery(this).prop("checked") == false){
               jQuery(this).removeAttr("checked", "checked");
            }
        });
/*---------------------------------------------------------*/
$(".next_btn").click(function() { // Function Runs On NEXT Button Click
	jQuery('html, body').animate({
        scrollTop: jQuery(".stepform").offset().top -100
    }, 500);

	var input_field = $('#activefield .required .input_field'); // Fetching All Inputs With Same Class Name text_field & An HTML Tag textarea
	var text_area = $('#activefield .required textarea');
	var fieldset = $('fieldset');
	var indexing = $(this).parents().next().index()-1;
// For Loop To Count Blank Inputs
	var result= "";
	var positions = [];
	var count = 0; // To Count Blank Fields
	for (var i = input_field.length; i > 0; i--) {
		positions.push(
        input_field[i-1].value
    );
    result += input_field[i-1].value + " ";
	if (input_field[i-1].value == '') {
	count = count + 1;
	}
	else {
	count = 0;
	}

	}
	positions = jQuery.grep(positions, function( n, i ) {
  	return ( n == "");
	});
//	alert(positions.length);
	// Notifying Validation

if (!$("#activefield .required input[type=checkbox]").is(":checked") && $('#activefield .required .input_field').is(':checkbox') || !$("#activefield .required input[type=radio]").is(":checked") && $('#activefield .required .input_field').is(':radio') || positions.length > 0) {
var url=document.URL;
var arr=url.split('/');

if(arr[3] == 'por'){
alert('Existem campos sem preenchimento. Certifique-se de incluir as informações nos campos marcados como obrigatórios.');
} else{
	alert('Hay campos sin rellenar. Asegúrese de incluir la información en los campos marcados como obligatorios.');
}
	event.preventDefault();

	//$('.validation-errormsg').show();
	return false;
	} else {
		$('.stepfield').removeAttr('id', 'activefield');

	$(this).parents().next().css({'display': 'block'});
$(this).parent().parent().css({
'display': 'none'
});
	//alert($("ul#progressbar li span.step-index:contains('" + indexing + "')").text());
	if (indexing == $("ul#progressbar li span.step-index:contains('" + indexing + "')").text())
	{
		$(this).parent().parent().parents('.regform').find("ul#progressbar li").removeClass('active');
		$(this).parent().parent().parents('.regform').find("ul#progressbar li span.step-index:contains('" + indexing + "')").parent().addClass('active');
  }

$(this).parents('.stepfield').next().attr('id', 'activefield');
var progressbar = document.getElementById("progressbar");
var btns = progressbar.getElementsByClassName("steps");
for (var i = 0; i < btns.length; i++) {
  var current = document.getElementsByClassName("active");

} 

/*=====================*/
 var tmp = [];
var dataString = jQuery( this ).parents('form').serializeArray();  
var form = jQuery(this).parents('form');
var session= jQuery("#session_token").val();
var form_id= jQuery("#form_id").val();
var current_step = jQuery(".active .step-index").text();
var checkboxvalues = jQuery('input[type="checkbox"]').serialize();
jQuery("input[type='checkbox']:checked").each(function() {
                tmp.push(jQuery(this).val());
            })
		 dataString.push({name:jQuery("input[type='checkbox']").attr('name'), value: tmp});

jQuery.each(form[0].files, function(i, file) {
	dataString.append('file-'+i, file);
});
$.ajax({
  type:'POST',
  data:{ 
	action: 'myaction' , // this is the function in your functions.php that will be triggered
	fields: dataString,
	token: session,
	form_id: form_id
  },
  url:ajax_object.ajaxurl ,
  success:function(data) {
	//alert(data);
	window.history.pushState("", "", '?step=' + indexing);

  }
});
return true;
}
});

$(".pre_btn").click(function() { // Function Runs On PREVIOUS Button Click
	jQuery('html, body').animate({
        scrollTop: jQuery(".stepform").offset().top
    }, 500);
	$(this).parents().prev().css({'display': 'block'});
$(this).parent().parent().css({
'display': 'none'
});
$('.stepfield').removeAttr('id', 'activefield');

// Removing Class Active To Show Steps Backward;
$('.active').prev().addClass('active');
	$('.active:last').removeClass('active');
});
// Validating All Input And Textarea Field
var pageUrl=document.URL;
var getUrl =pageUrl.split('/?step='); 
//alert(getUrl[1]);
if(typeof getUrl[1] == "undefined" ){
$('.stepfield:first').attr('id', 'activefield'); 
$('.steps:first').addClass('active');
//alert(pageUrl);
} else {
	$( ".stepfield" ).each(function( index ) {
		if(getUrl[1]-1 == index) {
		//alert(index); 	
		$(this).attr('id', 'activefield'); 
		}
	});

	$( ".steps" ).each(function( index ) {
		if(getUrl[1]-1 == index) {
		//alert(index); 
		$(this).addClass('active');
		}
	});
}
$('fieldset:last').children('.next_btn').css({
'display': 'none'
});
$('fieldset:first').children('.pre_btn').css({
'display': 'none'
});


$('.validation-errormsg').hide();
$('#showprofile').click(function() {
$('.profilefield').clone().appendTo('#results');
});
$("input[name='submit_btn']").click(function(){
			 var selValue = $("input[type='radio']:checked").val();
			if(selValue == 'En-ejecución'){
	 $("input[name='file_ANEXOS']").prop('required',true);
	 	if($("input[name='file_ANEXOS']").val() == '')
	 		alert('step 9 file field is required');
			}
	 });
jQuery('.accept-filetype input[type="file"]').on('change', function() {
    var ext =jQuery(this).val().split('.').pop().toLowerCase();
	var filename = $(this).val();
	
    if($.inArray(ext, ['xlsx','xls']) == -1 && filename != '') {
		alert('invalid extension!');
		jQuery(this).val(null); 
		$(this).parent().find('.upload_file_field input').val(null);
	} else {
		var lastIndex = filename.lastIndexOf("\\");
	 	if (lastIndex >= 0) {
        	filename = filename.substring(lastIndex + 1);
    	}
		$(this).parent().find('.upload_file_field input').val(filename);
		jQuery(this).val(filename);
    }
});
	
	jQuery('.multiple input[type="file"]').on('change', function() {
    var ext =jQuery(this).val().split('.').pop().toLowerCase();
	var filename = $(this).val();
	//alert(filename);
    if(filename == '') {
		
		jQuery(this).val(null); 
		$(this).parent().find('.upload_file_field input').val(null);
	} else {
		var lastIndex = filename.lastIndexOf("\\");
	 	if (lastIndex >= 0) {
        	filename = filename.substring(lastIndex + 1);
    	}
		$(this).parent().find('.upload_file_field input').val(filename);
		jQuery(this).val(filename);
    }
});

//validation for Allow digits only
jQuery(document).on("input", 'input[type="number"]', function() {
    this.value = this.value.replace(/\D/g,'');
});
jQuery('<div class="popup-total-price"><label class="col-10">Precio Total:</label><span id="result" class="col-2">0%</span></div>').insertAfter('.total-percent-1.markup-total');
	jQuery('<div class="popup-total-price"><label class="col-10">Precio Total:</label><span id="result1" class="col-2">0%</span></div>').insertAfter('.total-percent-2.markup-total');
	var delay = (function(){
  var timer = 0;
  return function(callback, ms){
  clearTimeout (timer);
  timer = setTimeout(callback, ms);
 };
})();
jQuery('.total-percent-1 input[type="number"]').keyup(function(){
	 delay(function(){

var perVal1 = jQuery('.per_0 input[type="number"]').val();
var perVal2 = jQuery('.per_1 input[type="number"]').val();
var perVal3 = jQuery('.per_2 input[type="number"]').val();

total = parseInt(perVal1)+parseInt(perVal2)+parseInt(perVal3);
	jQuery("#result").html(total + '%');	
 if(jQuery("#result").html() == 'NaN%'){
   jQuery("#result").html('');	
   }
	if(jQuery("#result").html() != '100%'){
		jQuery('.per_2 input[type="number"]').val(null);
		//alert('the total percentage should be 100%');
}
		 }, 1000 );
});
	
jQuery('.total-percent-2 input[type="number"]').keyup(function(){
	 delay(function(){

var perVal1 = jQuery('.per_3 input[type="number"]').val();
var perVal2 = jQuery('.per_4 input[type="number"]').val();
var perVal3 = jQuery('.per_5 input[type="number"]').val();

total = parseInt(perVal1)+parseInt(perVal2)+parseInt(perVal3);
	jQuery("#result1").html(total + '%');	
 if(jQuery("#result1").html() == 'NaN%'){
   jQuery("#result1").html('');	
   }
	if(jQuery("#result1").html() != '100%'){
		jQuery('.per_5 input[type="number"]').val(null);
	//	alert('the total percentage should be 100%');
}
		 }, 1000 );
});

/*===================*/
  // Original JavaScript code by Chirp Internet: chirpinternet.eu
  // Please acknowledge use of this code by including this header.

});