<?php include 'core/init.php';
logged_in_redirect();


    if (empty($_POST) === false) {
       $username= $_POST['username'];
       $password=$_POST['password'];


       if (empty($username) === true or empty($password) === true) {
          $errors[]= 'enter your username and password';

       } else if (user_exist($username) === false) {
          $errors[]= 'you did \'nt registered' ;

       } else if (user_active($username) === false) {
          $errors[]= 'you hav\'nt activate your account' ;

       } else {

          if (strlen($password) > 32) {
            $errors[]='your password is too long';
          }

        $login=login($username,$password);
        if($login===false) {
            $errors[]='username and password combination incorrect';

        } else{

          $_SESSION['user_id']=$login;
          header('Location:index.php');
          exit();
         }

       }
} else {

  $errors[]= "No data received";
}

include 'include/overrall/header.php';

if (empty($errors) === false) {
?>
<h2>we tried to log you in..but...</h2>

<?php
echo output_errors($errors);
}
include 'include/overrall/footer.php';
?>
