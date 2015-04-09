jQuery(document).ready(function($){

	$('#npp-become-a-partner').submit(function(){
            
		    event.preventDefault();
			var str = $(this).serialize();	
			var url = $("input[name=p]").val()+"contacts/index.php";
			//alert(url);				 
			   $.ajax({			   
			   type: "POST", // the kind of data we are sending
			   url: url, // this is the file that processes the form data
			   data: str, // this is our serialized data from the form
			   success: function(msg){	// anything in this function runs when the data has been successfully processed
                                
                                $("#note").css('display','block');						 
									 
				},
                            error: function(msg){
                                $("#note").css('display','none');
                                $("#error").css('display','block');
                            }
			 });		

	});
});



function ajaxformsendmail(name,email,subject,contents){
	jQuery.ajax({
		type: 'POST',
		url: ajaxcontactajax.ajaxurl,
		data: {
			action: 'ajaxcontact_send_mail',
			acfname: name,
			acfemail: email,
			acfsubject:subject,
			acfcontents:contents
		}, 

		success:function(data, textStatus, XMLHttpRequest){
			var id = '#ajaxcontact-response';
			jQuery(id).html('');
			jQuery(id).append(data);
		},	 

		error: function(MLHttpRequest, textStatus, errorThrown){
		alert(errorThrown);
		}	
	});

}