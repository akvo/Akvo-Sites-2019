<?php

	class AKVO_ADMIN{

		var $menu;
		var $submenu;

		function __construct(){

			/* SUPPORT LINK */
			add_action( 'admin_notices', function(){
				include "templates/support.php";
			} );

			/* REMOVE HELP FROM DASHBOARD */
			add_filter( 'contextual_help', array( $this, 'contextual_help' ), 999, 3 );

			// REMOVE LINKS FROM TOP ADMIN BAR
			add_action( 'admin_bar_menu', array( $this, 'admin_bar_menu' ), 999 );

			add_action( 'wp_dashboard_setup', array( $this, 'remove_dashboard_items' ) );

			/* SHOW EXTRA FIELDS */
			//add_action( 'show_user_profile', array( $this, 'extra_user_profile_fields' ) );
			//add_action( 'edit_user_profile', array( $this, 'extra_user_profile_fields' ) );

			/* SAVE EXTRA FIELDS */
			//add_action( 'personal_options_update', array( $this, 'save_extra_user_profile_fields' ) );
			//add_action( 'edit_user_profile_update', array( $this, 'save_extra_user_profile_fields' ) );


			/* HIDE MENU ITEMS */
			//add_action( 'admin_init', array( $this, 'hide_menu_items' ) );

			/* ADMIN ENQUEUE SCRIPTS */
			//add_action( 'admin_enqueue_scripts', array( $this, 'assets' ) );

		}

		function assets(){
			//wp_enqueue_script( 'akvo-admin', get_template_directory_uri() . '/dist/scripts/admin-main.js', array('jquery'), '1.0.1' );
		}

		/*
		function hide_menu_items(){
			global $menu, $submenu;

			// SAVING THE OLD MENU FOR REUE IN THE USER FIELDS
			$this->menu = $menu;
			$this->submenu = $submenu;

			$current_user = wp_get_current_user();

			// IF NOT LOGGED IN THEN RETURN
			if( !isset( $current_user->ID ) ) return false;

			// SELECTED MENU ITEMS FOR HIDING
			$menu_arr = is_array( get_user_meta( $current_user->ID, 'user_menu', true ) ) ? get_user_meta( $current_user->ID, 'user_menu', true ) : array();
			$submenu_arr = is_array( get_user_meta( $current_user->ID, 'user_submenu', true ) ) ? get_user_meta( $current_user->ID, 'user_submenu', true ) : array();

			// FINALLY HIDE MENU PAGES
			foreach( $menu_arr as $menu_item ){ remove_menu_page( $menu_item ); }

			// FINALLY HIDE SUBMENU PAGES
			foreach( $submenu_arr as $submenu_item ){
				$submenu_item = explode(':', $submenu_item );
				if( count( $submenu_item ) > 1 ){
					remove_submenu_page( $submenu_item[0], $submenu_item[1] );
				}
			}
		}
		*/

		function contextual_help($old_help, $screen_id, $screen){
			$screen->remove_help_tabs();
    		return $old_help;
		}

		function admin_bar_menu( $wp_admin_bar ){
			// REMOVE LOGO
			$wp_admin_bar->remove_node( 'wp-logo' );
			$wp_admin_bar->remove_node( 'new-post' );

			$wp_admin_bar->add_node(  array(
				'id'    => 'akvo-sites-support',
				'title' => 'Support',
				'href'  => 'http://sitessupport.akvo.org/form',
				'meta'  => array( 'class' => 'my-toolbar-page' )
			) );
		}

		function remove_dashboard_items(){
			global $wp_meta_boxes;

	    	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
    		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
    		//unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
    		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
    		//unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_drafts']);
    		//unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
    		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
    		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
    		unset($wp_meta_boxes['dashboard']['normal']['core']['tribe_dashboard_widget']);
		}

		/*
		function extra_user_profile_fields( $user ) {
			$exclude_menu = array( 'index.php', 'users.php', 'options-general.php' );
			$exclude_submenu = array( 'index.php', 'profile.php', 'data-feed-options' );

			$labels_menu = array(
				'index.php'				=> 'Dashboard',
				'users.php'				=> 'Users',
				'options-general.php'	=> 'Settings'
			);

			$selected_menu = is_array( get_user_meta( $user->ID, 'user_menu', true ) ) ? get_user_meta( $user->ID, 'user_menu', true ) : array();
			$selected_submenu = is_array( get_user_meta( $user->ID, 'user_submenu', true ) ) ? get_user_meta( $user->ID, 'user_submenu', true ) : array();

			$submenu = $this->submenu;


		?>
			<h3><?php _e("Hide Menu Items"); ?></h3>
			<table class="form-table">
				<!--tr>
					<td>
						<label>
							<input type="checkbox" data-behaviour='toggle-menu-items' />
							Select All
						</label>
					</td>
				</tr-->
				<!-- MAIN MENU ITEMS -->
				<tr><td><ul>
				<?php foreach( $this->menu as $menu_item ): ?>
					<?php if( isset( $menu_item[0] ) && $menu_item[0] && isset( $menu_item[2] ) && $menu_item[2] && !in_array( $menu_item[2], $exclude_menu ) ):?>
					<li class="hide-menu-items"><label>
						<input <?php if( in_array( $menu_item[2], $selected_menu ) )_e("checked='checked'");?> type="checkbox" name="user_menu[]" id="user-menu" value="<?php echo $menu_item[2]; ?>" />
						<?php _e( $menu_item[0] );?>
					</label></li>
					&nbsp;&nbsp;
					<?php endif;?>
				<?php endforeach;?>
				</ul></td></tr>
				<!-- END OF MAIN MENU ITEMS -->
				<!-- SUB MENU ITEMS -->
				<tr><td><ul>
				<?php foreach( $exclude_menu as $menu_slug ):?>
					<?php if( isset( $submenu[ $menu_slug ] ) && is_array( $submenu[ $menu_slug ] ) ):foreach( $submenu[ $menu_slug ] as $menu_item ):?>
					<?php if( isset( $menu_item[0] ) && $menu_item[0] && isset( $menu_item[2] ) && $menu_item[2] && !in_array( $menu_item[2], $exclude_submenu ) ):?>
					<li class="hide-menu-items"><label>
						<?php $menu_val = $menu_slug.":".$menu_item[2];?>
						<input <?php if( in_array( $menu_val, $selected_submenu ) )_e("checked='checked'");?> type="checkbox" name="user_submenu[]" id="user-submenu" value="<?php echo $menu_val; ?>" />
						<?php _e( $labels_menu[ $menu_slug ]." : ".$menu_item[0] );?>
					</label></li>
					<?php endif;endforeach;endif;?>
				<?php endforeach; ?>
				</ul></td></tr>
				<!-- END OF SUB MENU ITEMS -->
			</table>
			<style>
				li.hide-menu-items{
					display:inline-block;
					min-width: 200px;
				}
				li.hide-menu-items .update-count, li.hide-menu-items .plugin-count, li.hide-menu-items .pending-count{ display:none; }
			</style>
			<script>
				//alert( jQuery );
			</script>
		<?php }


		function save_extra_user_profile_fields( $user_id ) {
			if ( !current_user_can( 'edit_user', $user_id ) ) {
				return false;
			}
			update_user_meta( $user_id, 'user_menu', $_POST['user_menu'] );
			update_user_meta( $user_id, 'user_submenu', $_POST['user_submenu'] );
		}
		*/


	}

	global $akvo_admin;

	$akvo_admin = new AKVO_ADMIN;
