<?php
include 'core/init.php';
logged_in_redirect();
include 'include/overrall/header.php';
?>
    <h1>Recover</h1>
<?php

if (isset($_GET['success']) === true && empty($_GET['success']) === true) {
?>

<p>
  Thanks,we've emailed you!!
</p>

<?php
} else {

        $mode_alowed=array('username','password');
        if (isset($_GET['mode']) === true && in_array($_GET['mode'], $mode_alowed) === true){
          if (isset($_POST['email']) === true && empty($_POST['email']) === false) {
            if (email_exist($_POST['email']) === true) {
              recover($_GET['mode'], $_POST['email']);
              header('Location:recover.php?success');
              exit();


            }else {
              echo '<p>we couldn\'t find the email address</p>';
            }
          }

        ?>

        <form action="" method="post">

          <ul>
            <li>Please Enter your email address: <br>
            <input type="text" name="email"></li>

            <li><input type="submit" value="recover"></li>


            </address></li>
          </ul>

        </form>


        <?php



        } else {
         header('Location:index.php');
         exit();
        }
}
 ?>



<?php include 'include/overrall/footer.php';?>
