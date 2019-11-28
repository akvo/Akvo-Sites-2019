<?php 
	$akvo_card_obj = new Akvo_Card;
	$post_type_arr = $akvo_card_obj->get_types(); 
?>
<p>
    <label for="<?php echo $this->get_field_id( 'type' ); ?>"><?php _e('Type:', 'single_post'); ?></label> 
    <select id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>" class="widefat" style="width:100%;">
      	<?php foreach($post_type_arr as $post_type => $val):?>
      	<option <?php if ($post_type == $instance['type']) echo 'selected="selected"'; ?> value="<?php _e($post_type);?>"><?php _e($val);?></option>
        <?php endforeach;?>
    </select>
</p>
<p>
	<label for="<?php echo $this->get_field_id('rsr-id'); ?>"><?php _e('RSR ID (from data-feed):', 'single_post'); ?></label> 
	<input id="<?php echo $this->get_field_id('rsr-id'); ?>" type='text' name="<?php echo $this->get_field_name('rsr-id'); ?>" value="<?php _e($instance['rsr-id']);?>" />
</p>
<p>
	<label for="<?php echo $this->get_field_id('type-text'); ?>"><?php _e('Custom Tag (such as news, blog, etc):', 'single_post'); ?></label> 
	<input id="<?php echo $this->get_field_id('type-text'); ?>" type='text' name="<?php echo $this->get_field_name('type-text'); ?>" value="<?php _e($instance['type-text']);?>" />
</p>