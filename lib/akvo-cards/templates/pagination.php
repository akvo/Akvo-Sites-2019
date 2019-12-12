<nav class="navigation pagination" role="navigation" aria-label="Posts">
	<h2 class="screen-reader-text">Posts navigation</h2>
	<div class="nav-links">
		<?php if( $current_page != 1 ):?>
    <a class="next page-numbers" href="?<?php _e( 'card-page=' . ($current_page - 1) );?>">Previous</a>
    <?php endif; ?>
    <?php
      $mid_size = 1;
      for( $i = 1; $i <= $num_pages; $i++ ){
        if( ( $i == 1 ) || ( $i == $current_page - $mid_size ) || ( $i == $current_page ) || ( $i == $current_page + $mid_size ) || ( $i == $num_pages ) ){

          if( ( $i == $current_page - $mid_size && $i != 1 ) || ( $i == $current_page + $mid_size && $i != $num_pages ) ){
            echo '<span class="page-numbers dots">…</span>';
          }
          elseif ( $i == $current_page ) {

            if( $i-1 > 1  ){
                $this->page_num( $i-1, $current_page );
            }
            $this->page_num( $i, $current_page );
            if( $i+1 < $num_pages  ){
              $this->page_num( $i+1, $current_page );
            }
          }
          else{
            $this->page_num( $i, $current_page );
          }
        }
      }
    ?>
    <?php if( $current_page != $num_pages ):?>
    <a class="next page-numbers" href="?<?php _e( 'card-page=' . ( $current_page + 1 ) );?>">Next</a>
    <?php endif;?>
  </div>
</nav>
