<form action="<?php _e( admin_url( 'edit.php?post_type=fb_post&action=import&page='.$_GET['page'] ) );?>" method="POST">
<?php 

	$fbPostsTable = new FB_POSTS_LIST_TABLE;
	
	$fbPostsTable->process_bulk_action();
	
	$fbPostsTable->prepare_items();
	
	$fbPostsTable->display();
	
?>
</form>	
<style>
	#post-date, #image{
		width: 120px;
	}
	
	
	@media(max-width:768px){
		.wp-list-table tr:not(.inline-edit-row):not(.no-items) td:not(.column-primary)::before{
			display: none;
		}	
		#name {
			width: 100%;
		}
		#image, #desc, #post-date{
			display: none;
		}
	}
</style>
	
	
	