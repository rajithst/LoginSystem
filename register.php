<?php
include 'core/init.php';
logged_in_redirect();
include 'include/overrall/header.php';

 if (empty($_POST)===false) {
    $reuired_fields = array('username','password','password_again','f_name','email');
    foreach ($_POST as $key => $value) {
      if (empty($value) && in_array($key,$reuired_fields) === true  ) {
        $errors[]='Fields marked with asterisk are required';
        break 1;
      }
    }

    if (empty($errors) === true) {
      if (user_exist($_POST['username']) === true) {
        $errors[]='sorry,the username \'' . $_POST['username'] . '\' is already taken.';
      }

      if (preg_match("/\\s/",$_POST['username']) ==true) {
        echo " white space not allowed ";
      }

      if (strlen($_POST['password']) < 6 ) {
        $errors[] = 'password must be at least 6 characters';
      }

      if ($_POST['password'] !== $_POST['password_again']) {
        $errors[]= 'Your passwords do not match';
      }

     if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
       $errors[]='valid email address is required';
     }

     if (email_exist($_POST['email']) === true) {
       $errors[]='sorry,the email \'' . $_POST['email'] . '\'  is already taken';
     }

    }
 }

?>

    <h1>Register</h1>

  <?php


  if (isset($_GET['success']) && empty($_GET['success'])) {
    echo ' You\' ve been registered successfully!!!! ' . '<br>' . 'please check your emal to activate your account';

  } else {

      if (empty($_POST) === false && empty($errors) === true)  {


          $register_data = array(

          'username' =>  $_POST['username'],
          'password' =>  $_POST['password'],
          'f_name'   =>  $_POST['f_name'],
          'l_name'   =>  $_POST['l_name'],
          'email'    =>  $_POST['email'],
          'email_code' => md5($_POST['username'] + microtime())
       );

       register_user($register_data);
       header('Location:register.php?success');
       exit();

     } else if(empty($errors) === false) {
         echo output_errors($errors);
      }

  ?>

      <form action="" method="post">
        <ul>
          <li>
            Username*: <br>
            <input type="text" name="username" >
          </li>
          <li>
            Password*: <br>
            <input type="password" name="password">

          </li>

          <li>
            Password again*: <br>
            <input type="password" name="password_again" >

          </li>

          <li>
            First Name*: <br>
            <input type="text" name="f_name">
          </li>

           <li>
              Last Name: <br>
              <input type="text" name="l_name">
            </li>

            <li>
                Email*: <br>
                <input type="text" name="email">
            </li>

            <li>
              <input type="submit" value="Register">

            </li>
        </ul>

      </form>

<?php
}

 include 'include/overrall/footer.php'?>
