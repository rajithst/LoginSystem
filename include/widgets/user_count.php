<div class="widget">
    <h2>Members </h2>
    <div class="inner">
     <?php
      $user_count=user_count();
      $suffix=($user_count == 1) ? '' : 's';

      ?>
       We Currently have <?php echo $user_count; ?> registered member<?php echo $suffix; ?>
    </div>

</div>
