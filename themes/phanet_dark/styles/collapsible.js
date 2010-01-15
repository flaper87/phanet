$( document ).ready(function(){	
	
	$('div.block div.text', this).each(function() { 
		if ( $(this).attr("id") != "notToggle" ) {
			$( "div.text", this.parentNode ).slideToggle("instant");
			$( "div.title", this.parentNode ).css("cursor", "pointer");
		}
	})
	
	$( 'div.collapse_expand_all', this ).css("cursor", "pointer");
	
	$( 'div.single_post div.title_date', this ).each(function() {
			$( this ).css("cursor", "pointer");
	})
	
	$( 'div.block div.title', this ).click(function() {
			if ( $(this).attr("id") != "notToggle" ) {
				$( "div.text", this.parentNode ).slideToggle("slow");	
			}
		})
		
	$( 'div.single_post div.title_date', this ).click(function() {
			$( "div.post_content", this.parentNode ).slideToggle("slow");	
		})
		
	$( 'div.collapse_expand_all', this ).click(function() {
			if ( $(this).text() == "Collapse All")
				$( this ).html("Expand All")
			else
				$( this ).html("Collapse All")
			$( "div.post_content", $(document) ).slideToggle("slow");	
	})
});
