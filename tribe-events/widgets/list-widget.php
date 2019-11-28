<?php
/**
 * Events List Widget Template
 * This is the template for the output of the events list widget.
 * All the items are turned on and off through the widget admin.
 * There is currently no default styling, which is needed.
 *
 * This view contains the filters required to create an effective events list widget view.
 *
 * You can recreate an ENTIRELY new events list widget view by doing a template override,
 * and placing a list-widget.php file in a tribe-events/widgets/ directory
 * within your theme directory, which will override the /views/widgets/list-widget.php.
 *
 * You can use any or all filters included in this file or create your own filters in
 * your functions.php. In order to modify or extend a single filter, please see our
 * readme on templates hooks and filters (TO-DO)
 *
 * @version 4.1.1
 * @return string
 *
 * @package TribeEventsCalendar
 *
 */
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}



$events_label_plural = tribe_get_event_label_plural();
$events_label_plural_lowercase = tribe_get_event_label_plural_lowercase();

$posts = tribe_get_list_widget_events();





// Check if any event posts are found.
if ( $posts ) : ?>

	<ul class="tribe-list-widget list-unstyled">
		<?php
		// Setup the post data for each event.
		foreach ( $posts as $post ) :
			setup_postdata( $post );
			?>
			<li class="small tribe-list">
				<?php echo tribe_event_featured_image( $post->ID, 'full', false ); ?>
				<div class='tribe-list-title'>
					<a class="bold" href="<?php echo esc_url( tribe_get_event_link() ); ?>" rel="bookmark">
						<?php the_title(); ?>
					</a>
					<?php 
						$address = '';
						$city = tribe_get_city();
						if($city){
							$address .= $city.", ";
						}

						$region = tribe_get_region();
						if($region){
							$address .= $region.", ";
						}

						$country = tribe_get_country();
						if($country){
							$address .= $country;
						}
					?>
					<?php if($address):?>
					<span class='italic'>at <?php _e($address);?></span>
					<?php endif;?>
				</div>
				<div class="text-muted">
					<?php _e(truncate(get_the_excerpt(), 100)); ?>
				</div>
				<?php if(have_rows('partners')):?>
				<div>
					<span>Meet:</span>
					<?php 
						$i = 0; while(have_rows('partners')): the_row();
							if($i > 0){
								_e(', ');
							}
							the_sub_field('name');
							$i++;
						endwhile;
					?>
					
				</div>
				<?php endif;?>
				<div class="bold">
					<?php echo tribe_events_event_schedule_details(); ?>
				</div>
			</li>
		<?php
		endforeach;
		?>
	</ul><!-- .tribe-list-widget -->
	<?php
		$akvo_events = get_option('akvo_events');
		$btn_text = 'View All Events';
		
		if(isset($akvo_events['btn_text'])){
			$btn_text = $akvo_events['btn_text'];
		}
	?>
	<p class="tribe-events-widget-link">
		<a class='btn btn-default pull-right' href="<?php echo esc_url( tribe_get_events_link() ); ?>" rel="bookmark"><?php _e($btn_text); ?></a>
	</p>
<?php
// No events were found.
else : ?>
	<p><?php printf( esc_html__( 'There are no upcoming %s at this time.', 'the-events-calendar' ), $events_label_plural_lowercase ); ?></p>
<?php
endif;
