<div class="akvo-collapse-box">
  <a class="collapsed" data-toggle="collapse" href="#<?php echo $id;?>" aria-expanded="false" aria-controls="<?php echo $id;?>">
    <h5>
      <?php echo $title;?>
      <span class='open-icon pull-right'><i class='fa fa-plus'></i></span>
      <span class='closed-icon pull-right'><i class='fa fa-minus'></i></span>
    </h5>
    <p class="text-muted"><?php echo $subtitle;?></p>
  </a>
  <div class="collapse" id="<?php echo $id;?>">
    <?php echo $description;?>
  </div>
</div>
