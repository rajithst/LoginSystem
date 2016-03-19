<?php
include 'core/init.php';
logged_in_redirect();
include 'include/overrall/header.php';

if (isset($_GET['success'])=== true && empty($_GET['success']) === true ) {
?>

    <h2>We  activated your account</h2>
    <p> please log in </p>

<?php

} else if (isset($_GET['email'] ,$_GET['email_code']) === true) {
   $email = trim($_GET['email']);
   $email_code=trim($_GET['email_code']);


if (email_exist($email) === false) {
  $errors[]='opps,something went wrong,and we couldn\'t find that email address';
} else if (activate($email,$email_code) === false) {
  $errors[]='we had some problems activating your account';
}

if (empty($errors) === false) {

?>
  <h2> OOOPS...... </h2>
  <?php
  echo output_errors($errors);

} else {
  header('Location:activate.php?success');
  exit();
}

}else {
  header('Location:index.php');
  exit();
}



 include 'include/overrall/footer.php';

 ?>

