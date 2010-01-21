$( document ).ready(function(){	
	
	$('div.block div.text', this).each(function() { 
		if ( $(this).attr("id") != "notToggle" ) {
			$( "div.text", this.parentNode, "div.meta" ).slideToggle("instant");
			$( "div.title", this.parentNode, "div.meta" ).css("cursor", "pointer");
		}
	})

	$( 'div.block div.title', this ).click(function() {
			if ( $(this).attr("id") != "notToggle" ) {
				$( "div.text", this.parentNode, "div.meta" ).slideToggle("slow");	
			}
		})
		
	$('.collapse_expand_all').live("click", function() {
			if ( $(this).text() == "Trim")
				$( this ).html("Untrim")
			else
				$( this ).html("Trim")
		$( "div.post_content").addClass("hidden");
		$("div.single_post:odd").addClass("odd");
		$("div#posts").addClass("toggled");
		$(this).addClass('expand_all');
			
	$('.expand_all').live("click", function() {
		$( "div.post_content").removeClass("hidden");
		$(this).removeClass('expand_all');
		$("div#posts").removeClass("toggled");
		$("div.single_post:odd").removeClass("odd");
	})
	})
});
