!function(n){var i={common:{init:function(){},finalize:function(){}},home:{init:function(){},finalize:function(){n(".box-wrap.dyno .thumb-wrapper").each(function(){var i=n(this).innerWidth()-15,t=i/1.77777778;n(this).css({height:t+"px"})}),window.addEventListener("resize",function(i){n(".box-wrap.dyno .thumb-wrapper").each(function(){var i=n(this).innerWidth()-15,t=i/1.77777778;n(this).css({height:t+"px"})})})}},about_us:{init:function(){}}},t={fire:function(n,t,e){var o,c=i;t=void 0===t?"init":t,o=""!==n,o=o&&c[n],o=o&&"function"==typeof c[n][t],o&&c[n][t](e)},loadEvents:function(){t.fire("common"),n.each(document.body.className.replace(/-/g,"_").split(/\s+/),function(n,i){t.fire(i),t.fire(i,"finalize")}),t.fire("common","finalize")}};n(document).ready(t.loadEvents)}(jQuery);
//# sourceMappingURL=main.js.map

var $ = jQuery.noConflict();

/* Lazy Loading of the List */
(function($){
	/*
	function resizeHeader() {
    	$(".header-push").height($(".header3 .navbar").height());
	}
	resizeHeader();
	$(window).resize(resizeHeader);
	*/
	
	$.fn.ajax_loading = function(){
        return this.each(function(){
			var btn = $(this);
            
            var ul = $(btn.data('list'));
			
			
			ul.sanitize_url = function(){
				var url = ul.attr('data-url') ? ul.attr('data-url') : location.href;
				var hash_index = url.indexOf('#');
				if (hash_index > 0) { url = url.substring(0, hash_index);}
				url += (url.split('?')[1] ? '&':'?') + 'sjax=1';
				url = encodeURI(url);
				/* add page parameter to the request */
				var page = ul.page_inc();
				
				var paged = ul.attr('data-paged') ? ul.attr('data-paged') : 'paged';
				
				url += (url.split('?')[1] ? '&':'?') + paged + '=' + page;
				return url;
			};
			
			ul.page_inc = function(){
				var page = ul.attr('data-page') ? parseInt(ul.attr('data-page')) : 1;
				page += 1;
				ul.attr('data-page', page);
				return page;
			};
			
			ul.append_children = function(result){
				/*
				console.log(ul.attr('data-target'));
				console.log($(result).find(ul.attr('data-target')).length);
				
				console.log($(result).html());
				*/
				
				console.log( result );
				
				
				if($(result).find(ul.attr('data-target')).length){
					ul.attr('data-load-flag', '');
					btn.find('i').removeClass('fa-spin');
				}
				else{
					btn.hide();
				}
				
				$(result).find(ul.attr('data-target')).each(function(){
					var list = $(this);
					list.hide();
					list.appendTo(ul);
					list.show('slow');
					list.trigger('sjax:init', [list]);
				});	
			};
			
			ul.ajax_load = function(){
				ul.attr('data-load-flag', 'ajax');
				
				var url = ul.sanitize_url();
				console.log('lazy load initiated');
				
				jQuery.ajax({
    				url : url,
        			success : function(result){
        				//console.log(result);
        				console.log('lazy loading from sjax');
						ul.append_children(result);
            		},
        			error : function(){
        				console.log('lazy loading error');
        				btn.hide();
        			}
        		});
				
				
				
			};
			
			btn.click(function(ev){
				console.log('lazy loading clicked');
				btn.find('i').addClass('fa-spin');
				ul.ajax_load();
			});
			
			
		});
    };
    
    
    $('body').find("[data-behaviour~=ajax-loading]").ajax_loading();
    
    
    
   
}(jQuery));


/* RELOAD HTML THROUGH AJAX */
(function($){

	$.fn.reload_html = function(){
        return this.each(function(){
			var el = $(this);
            
            /* for loading icon */
            el.html("<div style='text-align:center; padding: 20px;'><i class='fa fa-refresh fa-spin'></i></div>");
            
            jQuery.ajax({
    			url : el.attr('data-url'),
        		success : function(result){
        			//console.log(result);
        			console.log('reload html');
					el.html(result);
					el.find("[data-behaviour~=ajax-loading]").ajax_loading();
            	},
        		error : function(){
        			el.hide();
        		}
        	});
			
			
			
			
		});
    };
    $('body').find("[data-behaviour~=reload-html]").reload_html();
}(jQuery));


/* ajax form submission */
(function($){
    $.fn.ajax_form_submit = function(options){
        var options = $.extend({
            success : function(data){},
        }, options);
        return this.each(function(){
            var form = $(this);
            var url = form.attr('action') ? form.attr('action') : '';
            var method = form.attr('method') ? form.attr('method') : 'GET';
            $.ajax({'type':method,'url':url,'data':form.serialize(),'success':function(data){
            
            	if(method == 'GET'){
            		var target_url = url + "?" + form.serialize();
            		history.pushState({}, '', target_url);
	            	
            	}
            	
            	form.trigger('ajax_form:after', [form]);
                options.success(data);
            }});
        });
    };
}(jQuery));




/* init form to direct ajax */
(function($){
    $.fn.ajax_form = function(options){
        var options = $.extend({
            success : function(data){},
        }, options);
        return this.each(function(){
            var form = $(this);
            
            var target = $(form.data('target'));
            
            form.submit(function(event){
                event.preventDefault();
                form.find('i.fa.fa-refresh').addClass('fa-spin');
                target.css({opacity:0.5});
                form.ajax_form_submit({
                    'success':function(data){
                        target.css({opacity:1});
                        form.find('i.fa.fa-refresh').removeClass('fa-spin');
                        
                        
                        var new_data = $(data).find(form.data('target')).html();
                        
                        target.html(new_data);
                        
                        target.find("[data-behaviour~=ajax-loading]").ajax_loading();
                        
                    }
                });
            });
        });
    };
    $('body').find("[data-behaviour~=ajax-form]").ajax_form();
}(jQuery));



(function () {
	$('a[href="#search-modal"]').on('click', function(event) {
        event.preventDefault();
        $('#search-modal').addClass('open');
        $('#search-modal > form > input[type="search"]').focus();
    });
    
    $('#search-modal, #search-modal button.close').on('click keyup', function(event) {
        if (event.target == this || event.target.className == 'close' || event.keyCode == 27) {
            $(this).removeClass('open');
        }
    });
}(jQuery));
