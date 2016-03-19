
<aside>
<?php

    if (logged_in() === true) {
    include 'include/widgets/loggedin.php';
      } else {
    include 'include/widgets/login.php';
     }

    include 'include/widgets/user_count.php';


?>
</aside>
