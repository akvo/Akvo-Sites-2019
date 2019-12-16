<div class="row-col3" style="margin-bottom:30px;">
  <?php while( $this->query->have_posts() ) : $this->query->the_post();?>
  <div class="col">
  <?php

    $shortcode = covert_post_to_akvo_card_shortcode();
    //echo $shortcode;

    echo do_shortcode( $shortcode );											// PRINT SHORTCODE
  ?>
  </div>
  <?php endwhile;?>
</div>
