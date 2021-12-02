// A $( document ).ready() block.
jQuery( document ).ready(function() {
    show();

    /*============ Delete Fields =============*/
    jQuery( ".fieldgroup-remove" ).click(function() {
      jQuery(this).parents('.editform-fieldsets').empty();
    });
	
 
    jQuery( '.sortable' ).sortable();
    jQuery( '.sortable' ).disableSelection();
    

});



function show(){
  jQuery('.show').click(function() {
  var fired_button = jQuery(this).val();
  var newdiv = document.createElement("fieldset");
  newdiv.className += "fieldset";
  newdiv.innerHTML = "<input id=fieldtype type=hidden name=fieldtype value=" + fired_button +">";
  document.getElementById("form").prepend(newdiv);
  document.getElementById("popup").style.display = "block";

  });

  }
  function hide() {
    document.getElementById("popup").style.display = "none";
    document.getElementById("name").value = "";
    document.getElementById("field_heading").value = "";
    document.getElementById("country").value = "";
    document.getElementByclassName("fieldset").empty();
  }

  function add() {
    var fieldtype = document.getElementById("fieldtype").value;
    var fieldname = document.getElementById("name").value;
    var fieldheading = document.getElementById("field_heading").value;
    var field_label = document.getElementById("field_label").value;
    var options = document.getElementById("options").value;
    var below_description = document.getElementById("below_description").value;
    var wrapper_class = document.getElementById("wrapper_class").value;
    var steps = document.getElementById("stepIndex_popup").value;;
    var index = document.all('stepIndex');
	var stepIndex = document.all('stepIndex').length-1;
	//	alert(stepIndex-1);
  function checkIndex(index) {
    return index == steps;
  }
  //	var countIndex = document.all('stepIndex').findIndex();
    const urlParams = new URLSearchParams(window.location.search);
    const myParam = urlParams.get('action');
    //alert(myParam);
    
	//	alert(stepIndex-1);
	//var stepIndex = document.all('stepIndex').length;
  /*  if (fieldname == "") {
      alert("Please fill all fields.")
    } else { */
      document.getElementById("popup").style.display = "none";
      var newdiv = document.createElement("div");
      newdiv.className += "editform-fieldsets connected-sortable cont12 ui-sortable-handle";
      newdiv.id += "draggable";
    //  newdiv.innerHTML = "<input type=text name=fieldgroup_" + fieldname + "[fieldheading] value='"+fieldheading +"'><input type=text name=fieldgroup_"+ fieldname + "[fieldtype] value='"+ fieldtype +"'><input type=text name=fieldgroup_"+ fieldname + "[field_label] value='"+ field_label +"'><input type=text name=fieldgroup_"+ fieldname + "[name] value='"+fieldtype+"_"+ fieldname +"'><input type=text name=fieldgroup_"+ fieldname + "[below_description] value='"+ below_description +"'><input type=text name=fieldgroup_"+ fieldname + "[wrapper_class] value='"+ wrapper_class +"'>";
      if(fieldtype == 'step'){
        newdiv.innerHTML = "<div class='step_container'><input id='stepIndex' type=text name='"+fieldheading +"_step' value='"+fieldheading +"'></div>";

	  } else {
      if(myParam == '') {
        newdiv.innerHTML = "<div class='fieldset-group'><div class='fieldgroup-remove'><span><i class='fa fa-trash' aria-hidden='true'></i></span></div><div class='fieldgroup-fields'><p1>Heading</p1><input type=text name=fieldgroup_" + fieldname.split(' ')[0] + "[step_"+stepIndex+"][fieldheading] value='"+fieldheading +"'><p1>Field type</p1><input type=text name=fieldgroup_"+ fieldname.split(' ')[0] + "[step_"+stepIndex+"][fieldtype] value='"+ fieldtype +"'><p1>Field Label</p1><input type=text name=fieldgroup_"+ fieldname.split(' ')[0] + "[step_"+stepIndex+"][field_label] value='"+ field_label +"'><p1>Field Name</p1><input type=text name=fieldgroup_"+ fieldname.split(' ')[0] + "[step_"+stepIndex+"][name] value='"+fieldtype+"_"+ fieldname +"'><p1>Option values</p1><textarea name=fieldgroup_"+ fieldname.split(' ')[0] + "[step_"+stepIndex+"][options]>"+ options +"</textarea><p1>Below description</p1><input type=text name=fieldgroup_"+ fieldname.split(' ')[0] + "[step_"+stepIndex+"][below_description] value='"+ below_description +"'><p1>Wrapper class</p1><input type=text name=fieldgroup_"+ fieldname.split(' ')[0] + "[step_"+stepIndex+"][wrapper_class] value='"+ wrapper_class +"'></div></div>";
      	} else {
        newdiv.innerHTML = "<div class='fieldset-group'><div class='fieldgroup-remove'><span><i class='fa fa-trash' aria-hidden='true'></i></span></div><div class='fieldgroup-fields'><p1>Heading</p1><input type=text name=fieldgroup_" + fieldname.split(' ')[0] + "[step_"+steps+"][fieldheading] value='"+fieldheading +"'><p1>Field type</p1><input type=text name=fieldgroup_"+ fieldname.split(' ')[0] + "[step_"+steps+"][fieldtype] value='"+ fieldtype +"'><p1>Field Label</p1><input type=text name=fieldgroup_"+ fieldname.split(' ')[0] + "[step_"+steps+"][field_label] value='"+ field_label +"'><p1>Field Name</p1><input type=text name=fieldgroup_"+ fieldname.split(' ')[0] + "[step_"+steps+"][name] value='"+fieldtype+"_"+ fieldname +"'><p1>Option values</p1><textarea name=fieldgroup_"+ fieldname.split(' ')[0] + "[step_"+steps+"][options]>"+ options +"</textarea><p1>Below description</p1><input type=text name=fieldgroup_"+ fieldname.split(' ')[0] + "[step_"+steps+"][below_description] value='"+ below_description +"'><p1>Wrapper class</p1><input type=text name=fieldgroup_"+ fieldname.split(' ')[0] + "[step_"+steps+"][wrapper_class] value='"+ wrapper_class +"'></div></div>";
        }//	alert(fieldname.split(' ')[0]);
	  }
      jQuery(newdiv).insertAfter("#results");
      document.getElementById("name").value = "";
      document.getElementById("fieldtype").value = "";
      document.getElementById("field_heading").value = "";
      document.getElementById("field_label").value = "";
      document.getElementById("below_description").value = "";
      document.getElementById("stepIndex_popup").value = "";
    //}
  }

