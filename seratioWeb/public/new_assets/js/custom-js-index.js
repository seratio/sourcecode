var w = jQuery.noConflict(); 
w(document).ready(function () {	
	
	// -------- Initialise Carousel -------- //
   w('.carousel').carousel({ interval: 3000 });
   w('select.styled').customSelect();
	//IE project mouse over hack				
	w( this ).find( ".overlay").stop().animate({opacity:0},280);
	w( this ).find( ".overlaytext").stop().animate({opacity:0},280);
	
	});
	
	w( "div.services-wrapper .col-md-4 .services" ).mouseout(function() {
		w(".css-table",this).stop().animate({height:100+'%',top:'-'+0+'%'},530);
		w(".css-table",this).removeClass('mouseOver');
		w(".css-table",this).addClass('mouseOut');
		w(".css-table .data",this).css("display","none");	
		
	})
.mouseover(function() {
	w(".css-table",this).stop().animate({height:120+'%',top:'-'+10+'%'},430);
	w(".css-table",this).css({ backgroundColor: '#210e5e' });	
	w(".css-table",this).removeClass('mouseOut');
	w(".css-table",this).addClass('mouseOver');
	w(".css-table .data",this).css("display","block");	
});


w( "div.bottom-content .col-md-9 .storage" ).css("display","block");
//icon hover
w( "div.icon-wrapper .col-md-3" ).mouseout(function() {
		
	})
.mouseover(function() {
	var disp = w( "a span",this ).attr("class");
	w( "div.icon-wrapper .col-md-3" ).removeClass('active');
	w(this).addClass('active');
	w( "div.bottom-content .col-md-9 .storage,div.bottom-content .col-md-9 .removal,div.bottom-content .col-md-9 .caravan,div.bottom-content .col-md-9 .boat").css("display","none");
	w( "div.bottom-content .col-md-9 ."+disp ).css("display","block");
	
	
});









