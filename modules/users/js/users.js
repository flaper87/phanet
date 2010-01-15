
$( document ).ready(function() {
	$( "form", $( document ) ).validate({
		rules: { userEmail: {email: "Insert a valid email"}},
		
		errorLabelContainer: "#errorsBox",
		onfocusout: false,
		
		submitHandler: function(form) { 
					submitForm( form );	
							},
		wrapper: "li" }) }); 


function submitForm( form ) {
	$("#loading").html("<img src=\"media/loader.gif\" />").fadeIn("normal")
	$.ajax({
   		type: "POST",
   		url: $( form ).attr( "action" ),
   		data: $( form ).formSerialize(),
		async: true,
		contentType: 'application/x-www-form-urlencoded',
   		success: function(msg){
     		self.parent.tb_remove()},
		error:function (XMLHttpRequest, textStatus) { 
			if (XMLHttpRequest.status == "417") {
				$("#loading").html("")
				$("#errorsBox").html("<b>Wrong user name and/or password</b>").fadeIn("normal")
			} else if (XMLHttpRequest.status == "416") {
					$("#loading").html("")
					$("#errorsBox").html("<b>The user is already in use.</b>").fadeIn("normal")
			}
		}
 });
}