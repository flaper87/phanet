function checkAll(form) {
	for (i=0, n = form.elements.length; i < n; i++) {
		if (form.elements[i].type == 'checkbox' && !(form.elements[i].getAttribute('onclick',2))) {
			form.elements[i].checked = (form.elements[i].checked) ? false : true;
		}
	}
}

function getItemPos( item ){
	
		items = $( item ).parent().sortable('toArray', "name");
		
		for ( pos=0; pos < items.length; pos++ ) {
			if ( items[pos] == $( item ).attr('name') ) {
				widgetPos = pos;
			}
		}

		return widgetPos;
}


function updateWidgets( form ){
	$.ajax({
   		type: "POST",
   		url: $( form ).attr( "action" ),
   		data: $( form ).serialize(),
		async: true,
		contentType: 'application/x-www-form-urlencoded'
   		//success: ,
 });
 return false;
}


function widgetDragStart( ui ) { 
	$( ui.item ).attr( 'startListId', $( ui.item ).parent().attr('id') ); 
	$( ui.item ).attr( 'startPos', getItemPos( ui.item )) ;
} 

function widgetDragStop( ui ) {

	widgetName = $( ui.item ).attr( 'name' )

	widgetPos = getItemPos( $( ui.item ), widgetName );
	
	
	$('*', ui.item ).each(function() { 
		if ( $(this).attr('id') == "widgetPath" )  {
			widgetPath = $(this).attr('value');
		}
			
	})
		
	if ($(ui.item).parent().attr('id') != $(ui.item).attr('startListId')) {
		if ($(ui.item).parent().attr('id') == "enabledlist") {
			$.get("?admin=options-widgets&add=widget", {
				wName: widgetName,
				wPath: widgetPath,
				wPos: widgetPos
			});
			
			$nAvWidgets = $( "li", "#availableslist" ).length - 1;
			$nEnWidgets = $( "li", "#enabledlist" ).length;
	
			$( $( 'h4', ui.item )  ).css({backgroundColor: '#1f6f94'})
			$( $( '#availableLog', document )  ).html("<b>" + $nAvWidgets + " Widgets Available</b>");
			$( $( '#enabledLog', document )  ).html("<b>" + $nEnWidgets + " Widgets Enabled</b>")
				
		} else { 
			$nAvWidgets = $( "li", "#availableslist" ).length;
			$nEnWidgets = $( "li", "#enabledlist" ).length - 1;
			$.get("?admin=options-widgets&remove=widget", {
				wName: widgetName
			});
			
			$( $( 'h4', ui.item )  ).css({backgroundColor: '#539bbb'})
			$( $( '#availableLog', document )  ).html("<b>" + $nAvWidgets + " Widgets Available</b>");
			$( $( '#enabledLog', document )  ).html("<b>" + $nEnWidgets + " Widgets Enabled</b>")
		}
			
	} else if ( $( ui.item ).parent().attr( 'id' ) == $( ui.item ).attr( 'startListId' ) 
				&& $( ui.item ).parent().attr( 'id' ) == "enabledlist"
				&& $( ui.item ).attr( 'startPos' ) != widgetPos) {
		
		var path = new Array();
		
		names = $( ui.item ).parent().sortable('toArray', "name")
		
		pos=0;
		$( "#enabledlist #widgetPath").each(function(){
			path[pos] = { "name": names[pos], "path": $( this ).attr('value') } 
			pos++	
		});
		
		$.get("?admin=options-widgets&update=widget", {'itArr[]':names})
			//{wName:widgetName, wPos:widgetPos, wPath:widgetPath,
			//oldPos: $( this ).attr( 'startPos' )});
	}
}


//function saveWidgets(){
	//var contenedor;
	
//}

function checkSmtp( href ) {
	$.ajax({
   		type: "POST",
   		url: href,
   		//data: $( form ).formSerialize(),
		async: true,
		contentType: 'application/x-www-form-urlencoded',
   		success: function(msg){
     		$( "#checkSmtp", document ).html( "Success" )},
     	error:function ( XMLHttpRequest ) { 
     		if (XMLHttpRequest.status == "419") {
				$( "#checkSmtp", document ).html( "Failed!! Retry" )
			}
		}
 });
}

$(document).ready(function(){
	
	$('a#checkSmtp').each(function() {
		var href = $(this).attr("href");
      	$(this).attr({ href: "#"});
		$(this).click(function(){ checkSmtp( href ) })
	})
	
	//avlist = document.getElementById("availableslist")
	//enlist = document.getElementById("enabledlist")
	
	//if (avlist && enlist) {
		$('#availableslist').sortable({
			connectWith: ['#enabledlist'], 
			opacity: 0.8,
			revert: true,
			placeholder: "draging",
			start: function(e, ui){ widgetDragStart(ui) },
			stop: function(e, ui){ widgetDragStop(ui) }});
			
		$('#enabledlist').sortable({
			connectWith: ['#availableslist'], 
			opacity: 0.8,
			revert: true,
			placeholder: "draging",
			start: function(e, ui){ widgetDragStart(ui) },
			stop: function(e, ui){ widgetDragStop(ui) }});
	//}

});
