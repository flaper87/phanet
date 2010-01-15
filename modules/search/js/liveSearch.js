
$( document ).ready(function() {
		$("#searchForm").submit(function(){
			//$("#searchLoading", this.parent ).html("<img src=\"media/loader.gif\" />")
			liveSearch( $( this ) )
			//$("#searchLoading").html("<img src=\"media/stop_grey.png\" />")
			return false;
			})
	}

)


function liveSearch( form ) {
	$.ajax({
   		type: "GET",
   		url: $( form ).attr( "action" ),
   		data: $( form ).formSerialize(),
		async: true,
		contentType: 'application/x-www-form-urlencoded',
   		success: function(msg){
     		$( "#posts", document ).html( $("#posts", msg).html() )},
 });
}
