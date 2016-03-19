<?php
include 'core/init.php';
protect_page();
include 'include/overrall/header.php';

if (empty($_POST)===false) {
   $reuired_fields = array('f_name','email');
   foreach ($_POST as $key => $value) {
     if (empty($value) && in_array($key,$reuired_fields) === true  ) {
       $errors[]='Fields marked with asterisk are required';
       break 1;
     }
   }

if (empty($errors) === true) {
   if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
     $errors[]='valid email address is required';
}
  else if  (email_exist($_POST['email']) === true && $user_data['email'] !== $_POST['email']) {
     $errors[]='sorry,the email \'' . $_POST['email'] . '\'  is already taken';
   }
  }
}

?>
<h2>Settings</h2>
<?php
if (isset($_GET['success'])===true && empty($_GET['success']) === true) {
  echo "updated";
} else {

    if (empty($_POST) === false && empty($errors) === true) {

      $update_data= array (

      'f_name' =>  $_POST['f_name'],
      'l_name' =>  $_POST['l_name'],
      'email'  =>  $_POST['email'],
      'allow_email' => ($_POST['allow_email'] == 'on') ? 1 :0

    );



    update_user($session_user_id,$update_data);
    header('Location:settings.php?success');
    exit();



    } elseif (empty($errors) === false) {
      echo output_errors($errors);
    }

     ?>

    <form action="" method="post">
      <ul>
        <li> First Name*: <br>
        <input type="text" name="f_name" value="<?php echo $user_data['f_name']; ?>">
        </li>

        <li> Last Name: <br>
        <input type="text" name="l_name" value="<?php echo $user_data['l_name']; ?>">
        </li>

        <li> Email*: <br>
        <input type="text" name="email" value="<?php echo $user_data['email']; ?>">
        </li>

        <li>
          <input type="checkbox" name="allow_email" <?php if ($user_data['allow_email']==1) {
          echo 'checked="checked"'; } ?>> Would You like to recieve email from us?
        </li>

        <li>
        <input type="submit" value="Update">
        </li>
      </ul>
    </form>



    <?php
    }
include 'include/overrall/footer.php';

?>
