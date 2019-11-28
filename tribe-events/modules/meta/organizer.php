<?php
/**
 * Single Event Meta (Organizer) Template
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe-events/modules/meta/details.php
 *
 * @package TribeEventsCalendar
 */

$organizer_ids = tribe_get_organizer_ids();
$multiple = count( $organizer_ids ) > 1;

$phone = tribe_get_organizer_phone();
$email = tribe_get_organizer_email();
$website = tribe_get_organizer_website_link();
?>

<div class="tribe-events-meta-group tribe-events-meta-group-organizer">
	<h3 class="tribe-events-single-section-title"><?php echo tribe_get_organizer_label( ! $multiple ); ?></h3>
	<dl>
		<?php
		do_action( 'tribe_events_single_meta_organizer_section_start' );

		foreach ( $organizer_ids as $organizer ) {
			if ( ! $organizer ) {
				continue;
			}

			?>
			<dt style="display:none;"><?php // This element is just to make sure we have a valid HTML ?></dt>
			<dd class="tribe-organizer">
				<?php echo tribe_get_organizer_link( $organizer ) ?>
			</dd>
			<?php
		}

		if ( ! $multiple ) { // only show organizer details if there is one
			if ( ! empty( $phone ) ) {
				?>
				<dt>
					
				</dt>
				<dd class="tribe-organizer-tel">
					<i class='fa fa-phone'></i>&nbsp;<?php echo esc_html( $phone ); ?>
				</dd>
				<?php
			}//end if

			if ( ! empty( $email ) ) {
				?>
				<dt>
					
				</dt>
				<dd class="tribe-organizer-email">
					<i class='fa fa-envelope'></i>&nbsp;<?php echo esc_html( $email ); ?>
				</dd>
				<?php
			}//end if

			if ( ! empty( $website ) ) {
				?>
				<dt>
					
				</dt>
				<dd class="tribe-organizer-url">
					<i class='fa fa-globe'></i>&nbsp;<?php echo $website; ?>
				</dd>
				<?php
			}//end if
		}//end if

		do_action( 'tribe_events_single_meta_organizer_section_end' );
		?>
	</dl>
</div>
