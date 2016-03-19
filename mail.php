<?php include 'core/init.php';
protect_page();
admin_protect();
      include 'include/overrall/header.php'; ?>

    <h1>Email</h1>



    <?php

    if (isset($_GET['success']) === true and empty($_GET['success']) === true)  {
        ?>
        <p>
            Email has been sent
        </p>


        <?php
    } else {

        if (empty($_POST) === false) {
          if (empty($_POST['subject']) === true) {
            $errors[]= 'subject required';

          }

          if (empty($_POST['body']) === true) {
            $errors[]= 'body required';

          }

          if (empty($errors) === false) {
            echo output_errors($errors);

          } else {

            mail_user($_POST['subject'],$_POST['body']);
            header('Location:mail.php?success');
            exit();

          }
        }


       ?>


      <form  action="" method="post">

        <ul>
          <li>Subject* <br>
            <input type="text" name="subject" value="">

          </li>

          <li>Body* <br>
            <textarea name="body" rows="8" cols="40"></textarea>
          </li>
          <li>
            <input type="submit" value="send">
          </li>

        </ul>

      </form>

  <?php

}

 include 'include/overrall/footer.php';?>
