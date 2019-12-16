<?php

  if( $this->query->max_num_pages > 1 ){
    $GLOBALS['wp_query']->max_num_pages = $this->query->max_num_pages;
    the_posts_pagination( array(
      'mid_size'  => 2,
      'prev_text' => __( 'Previous', 'textdomain' ),
      'next_text' => __( 'Next', 'textdomain' ),
    ) );
  }
