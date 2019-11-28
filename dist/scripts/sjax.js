var Sjax = function(){
    var loader = this;
    
    var base_url = "";
    
    this.cache = {};
    
    if(typeof(Storage) !== "undefined") {
	    //console.log('Local Storage is available');
	    
	   
	    this.cache = localStorage;
	    if(!this.cache){
	    	this.cache = {};
	    }
	    //console.log(this.cache);
	    
	} 
    
    this.callback = function(){};
    this.flag = false;
    /* sets up the environment */
    this.init = function(){
        var current_url = location.href;
        jQuery('body').attr('data-url',current_url);
        
        /* handles all the click events on the document */
        jQuery(document).on("click", "a[data-behaviour~=sjax], area[data-behaviour~=sjax]", function(event){
			
            var el = jQuery(this);
			if(!event.ctrlKey){
                /* enter only if ctrl key is not pressed with it */
                event.preventDefault();
                var confirm_text = el.attr('data-confirm');
                if(((confirm_text)&&(confirm(confirm_text)))||(!confirm_text)){
                    history.pushState({}, '', el.attr('href')); 
                    loader.load(el.attr('href'));
                    event.stopPropagation();
                }
            }    
        });
        
        /* events hacked on the back button */
        jQuery(window).on("popstate", function(event) { 
            /* checking on google chrome as popstate is refreshed on page load */
            if(jQuery('body').attr('data-url') && jQuery('body').attr('data-url') != location.href){ loader.load(location.href); } 
        });
        
    };
    
   
    
    this.sanitize_url = function(url){
        hash_index = url.indexOf('#');
        if (hash_index > 0) { url = url.substring(0, hash_index);}
        
        url += (url.split('?')[1] ? '&':'?') + 'sjax=1';
        url = encodeURI(url);
        
        //console.log(url.indexOf(base_url) > -1);
        
        if(url.indexOf(base_url) > -1){
        	//console.log(url);
        	return url;
        }
        else{
        	return base_url + url;
        }
    };
    
    this.findAll = function(elems, selector) {
        return elems.filter(selector).add(elems.find(selector));
    };
    
    this.parseHTML = function(html){
        return jQuery.parseHTML(html, document, true)
    }
    
    this.createLoader = function(){
        var div = jQuery(document.createElement('div'));
        div.addClass('loader');
        div.attr('id','page-loader');
		jQuery('body').prepend(div);
    };
    this.removeLoader = function(){  };
    
    this.parseURL = function(url){
        var a = document.createElement('a')
        a.href = url
        return a
    };
    
    this.fetch_online = function(options){
    };
    
    
    this.fetch = function(options){
    
    	var options = $.extend({
    		url : 'sample',
    		success : function(result){},
            error: function(){}
        }, options);
    
    	jQuery.ajax({
    		url : options.url,
        	success : function(result){
        		if(loader.cache[options.url] != result){
            		loader.cache[options.url] = result;
            	}
        		options.success(result);
            },
        	error : function(){
        		options.error();
        	}
        });
    };
    /*
    this.fetch = function(url, silent){
    	var silent = typeof silent !== 'undefined' ?  silent : false;

    	
        var navigate_flag = true;
		/* checking if the data exists in the cache 
        if(loader.cache[url]){
        	console.log('Loaded from the cache');
        	if(!silent){
				loader.update_dom(loader.cache[url], true);
			}	
            navigate_flag = false;
        }
        jQuery.ajax({url:url,success:function(result){
        	//console.log(result);
            if(loader.cache[url] != result){
            	console.log('Loaded from the server');
				/* execute only if the result is not the same as cache *
                loader.cache[url] = result;
                if(!silent){
                	loader.update_dom(result, navigate_flag);
                }
            }    
        }});
    };
    */
    
    
    this.navigate = function(){
        var original_url = jQuery('body').attr('data-url');
        /* navigate to the right location */
        var hash = loader.parseURL(original_url).hash;
        var target = jQuery(hash);
        if (target.length){ jQuery('body,html').animate({scrollTop: target.offset().top}, 300); }
        else{ jQuery('body,html').animate({scrollTop: 0}, 300);    }
    };
    
    this.update_dom = function(result, navigate_flag){
		
        /* update the title of the document */
        var jQueryhead = jQuery(loader.parseHTML(result.match(/<head[^>]*>([\s\S.]*)<\/head>/i)[0]));
        document.title = jQuery.trim(loader.findAll(jQueryhead, 'title').last().text());
        
		
			
        var jQuerybody = jQuery(loader.parseHTML(result.match(/<body[^>]*>([\s\S.]*)<\/body>/i)[0]));
        /* update the body class */
        var body_class = /body([^>]*)class=(["']+)([^"']*)(["']+)/gi.exec(result.substring(result.indexOf("<body"), result.indexOf("</body>") + 7));
        if(body_class){body_class = body_class[3];}
        jQuery('body').attr('class',body_class);
            
        /* update the contents of the body */
        jQuery('body').html(jQuerybody);
        
        if(navigate_flag){ loader.navigate(); }    
            
        jQuery('body').trigger('sjax:init', [jQuery('body')]);
		
    };
    
    /* heart of the loader class */
    this.load = function(original_url, callback){
        var loader = this;
        jQuery('body').attr('data-url',original_url);
        url = this.sanitize_url(original_url);
        
        loader.createLoader();
        
        var navigate_flag = true;
        /* checking if the data exists in the cache */
        var old_cache_result = loader.cache[url];
        if(old_cache_result){
        	console.log('Loaded from the cache');
        	loader.update_dom(old_cache_result, true);
        	navigate_flag = false;
        }
        /* fetching an online copy */
        loader.fetch({
        	'url':url, 
        	'success': function(result){
        		if(old_cache_result != result){
        			console.log('Loaded from the server');
        			loader.update_dom(result, navigate_flag);	
        		}
        		
        	}
        });
            
        
        
    };
    this.init();
    
    return this;
};
var sjax = Sjax();
jQuery('document').ready(function(){
	jQuery('body').trigger('sjax:init', [jQuery('body')]);
	
	
	
	
});



/* sjax preload all the links */
(function($){
    $.fn.sjax_preload = function(){
        return this.each(function(){
            var el = $(this);
            var url = sjax.sanitize_url(el.attr('href'));
       		if(!sjax.cache[url]){
       			sjax.fetch({'url':url});
       		}
       	});
    };
    $('body').on('sjax:init', function(event, el){
        el.find("[data-behaviour~=sjax-preload]").sjax_preload();
    }); 
}(jQuery));  	
  	
/* sjax img cache 
(function($){  	
  	$.fn.sjax_imgcache = function(){
        return this.each(function(){
            var target = $(this);
            ImgCache.isCached(target.attr('src'), function(path, success) {
  				if (success) {
  					//console.log('already cached');
  					ImgCache.useCachedFile(target);
  				} 
  				else {
    				//console.log('not there, need to cache the image');
    				ImgCache.cacheFile(target.attr('src'), function () {
      					ImgCache.useCachedFile(target);
    				});
  				}
			});
       	});
    };
  	
  	
  	$('body').on('sjax:init', function(event, el){
  		
  		ImgCache.init(function () {
	    		console.log('ImgCache init: success!');
	    		el.find("img").sjax_imgcache();
	    	}, function () {
    			console.log('ImgCache init: error! Check the log for errors');
		});
  		
  	}); 
  	
}(jQuery));

*/
