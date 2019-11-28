<div class='form-group'>
	<label><?php _e($arr['label']);?></label>
	<select name="akvo_<?php _e($arr['slug']);?>" class='form-control'>
		<?php 
			$default_text = 'Not Selected';
		
			$custom_text = get_option('akvo_filter_default_text');
			if($custom_text){
				$default_text = $custom_text;
			}
		?>	
		<option value='0'><?php _e($default_text);?></option>
		<?php foreach($terms as $term):
			$is_selected = false;
			if($arr['id'] == $term->term_id){
				$is_selected = true;
			}
		?>
		<option <?php if($is_selected) _e("selected='selected'");?> value='<?php _e($term->term_id);?>'><?php _e($term->name);?></option>
		<?php endforeach;?>
	</select>
</div>