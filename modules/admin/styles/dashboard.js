
$( document ).ready(function(){
	
	src = $('#widgetArrow', this).attr('src').replace(/(.*?\/)\w+\.\w+$/i,'$1');
	
	for (i=1; i<4; i++){
		//$( "li", "#dashWidgets" + i ).each(function() {
		$( "li", "#dashWidgets" + i ).each(function() {
			$( '#widgetArrow', this ).click(function() {
				li = $( $( $( this ).parent() ).parent()).parent()
				
				$( "div.dashWidget", li ).slideToggle("slow");
				
				 if ($( this ).attr('state') == 'shown' ) {
				 	$( this ).attr('src', src + 'arrow_right.png')
				 	$( this ).attr('state', 'hidden')
				 } else {
				 	$( this ).attr('src', src + 'arrow_down.png')
				 	$( this ).attr('state', 'shown')
				 }
			})
		})	
	}
	
	$('#dashWidgets1').sortable({
			handle: 'h4',
			connectWith: ['#dashWidgets2','#dashWidgets3'], 
			opacity: 0.8,
			revert: true,
			placeholder: "dashDraging"});
			
	$('#dashWidgets2').sortable({
			handle: 'h4',
			connectWith: ['#dashWidgets1','#dashWidgets3'], 
			opacity: 0.8,
			revert: true,
			placeholder: "dashDraging"});
			
	$('#dashWidgets3').sortable({
			handle: 'h4',
			connectWith: ['#dashWidgets1','#dashWidgets2'], 
			opacity: 0.8,
			revert: true,
			placeholder: "dashDraging"});

});