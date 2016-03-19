<?php
 include 'core/init.php';
include 'include/overrall/header.php';
 ?>

    <h1>Welcome </h1>
    <p>owner rajith thennakoon</p>


    <?php
    if (has_access($session_user_id,1) === true) {
      echo "Admin";
    } elseif (has_access($session_user_id,2)) {
      echo "Moderator";
    }

     ?>

<?php include 'include/overrall/footer.php';?>
