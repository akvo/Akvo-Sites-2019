<label>
	<# if ( data.label ) { #><span class="customize-control-title">{{{ data.label }}}</span><# } #>
	<# if ( data.description ) { #><span class="description customize-control-description">{{{ data.description }}}</span><# } #>
	
	<span class='loading'>Loading...</span>
	
	<select {{{data.link}}} data-behaviour='ajax-dropdown-control' data-url='{{{data.choices.url}}}'>
		<# _.each( data.choices, function( label, choice ) { #>
		<option value="{{ choice }}" <# if ( choice === data.value ) { #> selected="selected" <# } #>>{{ label }}</option>
		<# } ) #>
	</select>
</label>