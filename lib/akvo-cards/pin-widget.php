<?php

	/**
 	* Register the Widget
 	*/

	//add_action( 'widgets_init', create_function( '', 'register_widget("pin_post_widget");' ) );

	add_action( 'widgets_init', function( $args ){
		return register_widget( "pin_post_widget" );
	} );

class pin_post_widget extends WP_Widget
{
    /**
     * Constructor
     **/
    public function __construct()
    {
        $widget_ops = array(
            'classname' => 'pin_post_widget',
            'description' => 'Displays a pinned single post or RSR update'
        );

        parent::__construct( 'pin_post_widget', 'Pin Post Widget', $widget_ops );

        add_action('admin_enqueue_scripts', array($this, 'upload_scripts'));
    }

    /**
     * Upload the Javascripts for the media uploader
     */
    public function upload_scripts(){


    	$upload_js = get_bloginfo('template_url') . '/dist/scripts/upload-media.js';


        wp_enqueue_script('media-upload');
        wp_enqueue_script('thickbox');
        wp_enqueue_script('upload_media_widget', $upload_js, array('jquery'));

        wp_enqueue_style('thickbox');



    }


    public function widget( $args, $instance ){
    	echo do_shortcode('[akvo-card title="'.$instance['title'].'" type="'.$instance['type'].'" link="'.$instance['link'].'" img="'.$instance['image'].'" content="'.$instance['content'].'" date="'.$instance['date'].'"]');
    }


    public function update( $new_instance, $old_instance ) {

		$updated_instance = $new_instance;
        return $updated_instance;
    }

    /**
     * Displays the form for this widget on the Widgets page of the WP Admin area.
     *
     * @param array  An array of the current settings for this widget
     * @return void
     **/
    public function form( $instance ){

    	$defaults = array( 'type' => 'news');
		$instance = wp_parse_args( (array) $instance, $defaults );

    	$title = __('Untitled');
        if(isset($instance['title']))
        {
            $title = $instance['title'];
        }

        $image = '';
        if(isset($instance['image'])){
            $image = $instance['image'];
        }
        ?>
        <p>
            <label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>

		<p>
            <label for="<?php echo $this->get_field_name( 'date' ); ?>"><?php _e( 'Date:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'date' ); ?>" name="<?php echo $this->get_field_name( 'date' ); ?>" type="text" value="<?php echo $instance['date']; ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_name( 'image' ); ?>"><?php _e( 'Image:' ); ?></label>
            <input name="<?php echo $this->get_field_name( 'image' ); ?>" id="<?php echo $this->get_field_id( 'image' ); ?>" class="widefat" type="text" size="36"  value="<?php echo esc_url( $image ); ?>" />
            <input class="upload_image_button" type="button" value="Upload Image" style='margin-top:5px;' />
        </p>
        <?php
        	$post_type_arr = array(
				'news' => 'News',
				'blog' => 'Blog',
				'video' => 'Videos',
				'testimonial' => 'Testimonials',
				'project' => 'RSR Updates',
				'map' => 'Maps',
				'flow' => 'Flow',
				'media' => 'Media Library'
			);
        ?>
        <p>
            <label for="<?php echo $this->get_field_name('type'); ?>"><?php _e( 'Type:' ); ?></label>
            <select id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>" class="widefat" style="width:100%;">
      			<?php foreach($post_type_arr as $post_type => $val):?>
      			<option <?php if ($post_type == $instance['type']) echo 'selected="selected"'; ?> value="<?php _e($post_type);?>"><?php _e($val);?></option>
        		<?php endforeach;?>
        	</select>
        </p>

        <p>
            <label for="<?php echo $this->get_field_name( 'link' ); ?>"><?php _e( 'Link:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" type="text" value="<?php echo $instance['link']; ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_name( 'content' ); ?>"><?php _e( 'Content:' ); ?></label>
            <textarea class="widefat" id="<?php echo $this->get_field_id( 'content' ); ?>" name="<?php echo $this->get_field_name( 'content' ); ?>"><?php echo $instance['content']; ?></textarea>
        </p>
    <?php
    }
}
?>
