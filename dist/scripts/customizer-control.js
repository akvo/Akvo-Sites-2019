(function( $ ) {	
	
	var api = wp.customize;
	
	/*
	* DEVELOPER: SAMUEL V THOMAS
	* AJAX DROPDOWN THAT PULLS THE CHOICES FROM A URL. 
	* EXAMPLE USE CASE: LOADING GOOGLE FONTS AFTER THE FONTS HAVE BEEN MANUALLY ADDED THROUGH THE CUSTOMIZE
	*/
	
	api.controlConstructor['ajax_dropdown'] = api.Control.extend( {
		
		/*
		* EXTENDED FROM THE ORIGINAL CLASS
		* FIRED AS SOON AS THE PAGE LOADS
		*/
		ready: function() {
			
			var control = this;
			
			// HIDE THE SELECT FIELD BY DEFAULT
			control.getSelectField().hide();
			
			/* FIRED WHEN THE PARTICULAR CONTROL IS IN FOCUS */
			api.section( control.section() ).container.on( 'expanded', function() {
				
				control.getOptionsFromServer();
				
			});
			
		},
		
		// USER CREATED FUNCTION THAT RETURNS THE SELECT FIELD
		getSelectField: function(){
			var control 	= this,
				$select 	= control.container.find('[data-behaviour~=ajax-dropdown-control]');
			return $select;
		},
		
		// USER CREATED FUNCTION THAT DOES AN AJAX REQUEST TO THE URL AND UPDATES THE SELECT DROPDOWN
		getOptionsFromServer: function(){
			
			var control 	= this,
				$select 	= control.getSelectField(),
				url 		= $select.data('url'),
				$loading 	= control.container.find('.loading');
			
			
			// CHECK IF THE OPTIONS ARE EMPTY, THEN HIDE THE DROPDOWN AND SHOW ONLY THE LOADING
			if( ! $select.find('option').length ){
				
				// HIDE THE SELECT FIELD
				$select.hide();
				
				// SHOW LOADING
				$loading.show();
			}
			
			
			// AJAX REQUEST
			$.getJSON( url, function( data ) {
				
				// UPDATE THE OPTIONS ONLY IF THE LENGTH OF THE ARRAYS ARE DIFFERENT
				if( data.length != $select.find('option').length ){
				
					// RESET THE OPTIONS IN THE SELECT DROPDOWN
					$select.find('option').remove();
					
					// ADD THE OPTIONS FROM THE SERVER INTO THE SELECT FIELD
					_.each( data, function( label, choice ) {
						
						// DYNAMICALLY CREATING OPTION ELEMENTS
						var $option = $( document.createElement('option') )
						$option.attr( 'value', choice );
						$option.html( label );
						
						if( control.setting.get() == choice ){
							$option.attr( 'selected', 'selected' );
						}
						
						$select.append( $option );
						
					});
					
					// SHOW THE SELECT FIELD
					$select.show();
					
					// HIDE THE LOADING
					$loading.hide();
					
				}
				
			});
		}
	} );
	
	
})( jQuery );
	