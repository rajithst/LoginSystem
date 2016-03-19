<?php include 'core/init.php';
      include 'include/overrall/header.php';



if (isset($_GET['username']) === true && empty($_GET['username']) === false)  {

  $username= $_GET['username'];
  if (user_exist($username) === true) {
  $user_id=user_id_from_username($username);
  $profile_data=user_data($user_id,'f_name','l_name','email');
  $f_name=$profile_data['f_name'];
  $email=$profile_data['email'];

?>

 <h1> <?php echo $f_name; ?>'s Profile</h1>
 <p> <?php echo $email; ?></p>

<?php
} else {
   echo "sorry this user doesn't exist!!!!";
}

} else {
  header('Location:index.php');
  exit();
}

 include 'include/overrall/footer.php';?>
