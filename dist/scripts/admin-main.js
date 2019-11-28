(function($){
	
	$.fn.ajax_dropdown_control = function(){
        return this.each(function(){
			
			alert('hello');
			
			
		});
	};
	
	$('body').find("[data-behaviour~=ajax-dropdown-control]").ajax_dropdown_control();
	
	
	
}(jQuery));