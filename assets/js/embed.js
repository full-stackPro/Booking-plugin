cleanto_holder=document.getElementById('cleanto');
var sites_urls=document.getElementById('cleanto').getAttribute('data-url');

cleanto_holder.innerHTML='<object id="cleanto_content" style="width:100%; height:101%;" type="text/html" data="'+sites_urls+'" onload="cleantodivload()" ></object>';

var count_click = 0;
function cleantodivload(){
	jQuery(document).ready(function(){
		setTimeout(function() {	cleanto_demo_height();  }, 2000);
	});
	
	jQuery('#cleanto object').contents().find('.ser_details').click(function(e){
		count_click++;
		if(count_click == 1){
			setTimeout(function() {	cleanto_demo_height();  }, 5000);
		}
	});
	
	jQuery('#cleanto object').contents().find('.ct-radio-list').click(function(e){
		count_click++;
		if(count_click == 1){
			setTimeout(function() {	cleanto_demo_height();  }, 1000);
		}
	});
	
	jQuery('#cleanto object').contents().find('.cal_info').click(function(e){
		setTimeout(function() {	cleanto_demo_height();  }, 2000);
	});
	
	jQuery('#cleanto object').contents().find('.bi-terms-agree').click(function(e){
		setTimeout(function() {	cleanto_demo_height();  }, 1000);
	});
	
	jQuery('#cleanto object').contents().find('#login_existing_user').click(function(e){
		setTimeout(function() {	cleanto_demo_height();  }, 2000);
	});
}

function cleanto_demo_height(){	
	var new_page_height = jQuery('#cleanto object').contents().find('.ct-main-wrapper').height();
	
	jQuery('#cleanto').height(new_page_height);
	
	count_click = 0;
}