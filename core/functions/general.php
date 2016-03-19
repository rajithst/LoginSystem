 <?php
function email($to,$subject,$body){
  mail($to,$subject,$body, ' From:RSTBLOG@gmail.com');
}


function logged_in_redirect() {
  if (logged_in() === true) {
    header('Location:alreadylog.php');
    exit();
  }
}


 function protect_page() {
  if (logged_in() === false) {
    header('Location:protected.php');
    exit();
  }

 }

 function admin_protect(){
   global $user_data;
   if (has_access($user_data['user_id'],1) === false) {
     header('Location:index.php');
     exit();
   }
 }


 function array_sanitize($item) {
   $conn= mysqli_connect('localhost','root','','login');
   $item=htmlentities(strip_tags(mysqli_real_escape_string($conn,$item)));
 }

function sanitize ($data){
    $conn= mysqli_connect('localhost','root','','login');
    return htmlentities(strip_tags(mysqli_real_escape_string($conn,$data)));
}

function output_errors($errors) {
    return '<ul><li>'. implode('</li><li>',$errors) . '</li></ul>';
}

?>
