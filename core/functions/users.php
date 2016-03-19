<?php

	function change_profile_image($user_id,$file_temp,$file_extn) {
		$file_path='images/profile/' . substr(md5(time()),0,10) . '.' . $file_extn;
		move_uploaded_file($file_temp,$file_path);
		$query="UPDATE users SET profile = '" . $file_path . "' WHERE user_id= " . (int)$user_id;
		$conn= mysqli_connect('localhost','root','','login');
		mysqli_query($conn,$query);

	}


	function mail_user($subject,$body) {
		$conn= mysqli_connect('localhost','root','','login');
		$query=mysqli_query($conn,"SELECT * FROM users WHERE allow_email=1");
		$query2=mysqli_query($conn,"SELECT `email`,`f_name` users WHERE allow_email=1");
		$row=mysqli_fetch_assoc($query2);
		$rows=mysqli_num_rows($query);
		while ($rows>0) {
			email($row['email'],$subject, " Hello " . $row['f_name'] . ",\n\n"  . $body);
		}
	}


	function has_access($user_id,$type) {
		$user_id=(int)$user_id;
		$type= (int)$type;
		$conn= mysqli_connect('localhost','root','','login');
		$query=mysqli_query($conn,"SELECT * FROM users WHERE user_id=$user_id AND type=1");
		$rows=mysqli_num_rows($query);
		return($rows== 1) ? true : false;


	}

	function recover($mode,$email){
		$mode=sanitize($mode);
		$email=sanitize($email);

		$user_data=user_data(user_id_from_email($email),'user_id', 'f_name','username');

		if ($mode== 'username') {
			  email($email,'Your username',"Hello " .$user_data['f_name'].
			  ",\n \nYour username is :" .$user_data['username'] ."\n \n
			  RST BLOG

			");
		} else if ($mode=='password') {
			$generated_password=substr(md5(rand(999,999999)),0,8);
			change_password($user_data['user_id'],$generated_password);
			update_user($user_data['user_id'],array ('password_recover' => '1'));


		    email($email,'Your Password Recovery',"Hello " .$user_data['f_name'].
			  ",\n \nYour new password is :" .$generated_password ."\n \n
			  RST BLOG
			  ");
		}


	}

	function update_user($user_id,$update_data) {

	  $update=array();
	  array_walk($update_data,"array_sanitize");

	  foreach ($update_data as $field => $data) {
	    $update[]= '`' . $field . '` = \'' . $data . '\'';
	  }
	   $conn= mysqli_connect('localhost','root','','login');
	   mysqli_query($conn,"UPDATE users SET" . implode(' , ',$update) . "WHERE user_id = $user_id");


	}




	function activate($email,$email_code) {
	  $conn= mysqli_connect('localhost','root','','login');
	  $email= mysqli_real_escape_string($conn,$email);
	  $email_code= mysqli_real_escape_string($conn,$email_code);
	  $query=mysqli_query($conn,"SELECT * FROM users WHERE email = '$email' AND email_code='$email_code' AND active = 0 ");
	  $rows=mysqli_num_rows($query);
	  if ($rows == 1) {
	    $conn= mysqli_connect('localhost','root','','login');
	    mysqli_query($conn,"UPDATE users SET active=1 WHERE email='$email'");
	    return true;
	  } else {
	    return false;
	  }

	}


	function change_password($user_id,$password) {
	  $user_id=(int)$user_id;
	  $password=md5($password);
	  $conn= mysqli_connect('localhost','root','','login');
	  mysqli_query($conn,"UPDATE users SET password = '$password', password_recover=0 WHERE user_id = $user_id");
	}



	function register_user($register_data) {
	  array_walk($register_data,"array_sanitize");
	  $register_data['password'] = md5($register_data['password']);

	  $fields='`' .implode('`,`' ,array_keys($register_data)) . '`';
	  $data='\'' . implode('\', \'' ,$register_data ) . '\' ';

	   $conn= mysqli_connect('localhost','root','','login');
	   mysqli_query($conn,"INSERT INTO users($fields) VALUES ($data)");

	   email($register_data['email'],'Activate your account',"
	   Hello " . $register_data['f_name'] . ",\n \n

	   You need to activate your account,use the link below:\n \n

	    http://localhost/loginSystem/activate.php?email= " .$register_data['email'] . "&email_code= " . $register_data['email_code'] . " \n \n

	    -RST BLOG
	   ");

	}


	function user_count() {
	  $conn= mysqli_connect('localhost','root','','login');
	  $query=mysqli_query($conn,"SELECT * FROM users WHERE active=1");
	  $rows=mysqli_num_rows($query);
	  return $rows;
	}



	function user_data($user_id) {
	    $data= array();
	    $user_id=(int)$user_id;

	    $func_num_args=func_num_args();
	    $func_get_args=func_get_args();

	    if ($func_num_args > 1) {
	        unset($func_get_args[0]);

	        $fields='`' . implode('`, `',$func_get_args) . '`';

	        $conn= mysqli_connect('localhost','root','','login');
	        $query=mysqli_query($conn,"SELECT $fields FROM users WHERE user_id=$user_id");
	        $data=mysqli_fetch_assoc($query);
	        return $data;
	       die();

	    }

	}

	function logged_in() {

	    return (isset($_SESSION['user_id'])) ? true : false;
	}

	function email_exist($email) {

	   $conn= mysqli_connect('localhost','root','','login');
	    $email=sanitize($email);
	    $query=mysqli_query($conn,"SELECT * FROM users where email='$email'");
	    $result=mysqli_num_rows($query);
	    return($result == 1) ? true : false;

	}


	function user_exist($username) {

	   $conn= mysqli_connect('localhost','root','','login');
	    $user_exist=sanitize($username);
	    $query=mysqli_query($conn,"SELECT * FROM users where username='$username'");
	    $result=mysqli_num_rows($query);
	    return($result == 1) ? true : false;

	}

	function user_active($username) {


	    $conn= mysqli_connect('localhost','root','','login');
	    $user_exist=sanitize($username);
	    $query=mysqli_query($conn,"SELECT * FROM users where username='$username' AND active=1");
	    $result=mysqli_num_rows($query);
	    return($result == 1) ? true : false;

	}

	function user_id_from_username($username) {
	    $conn= mysqli_connect('localhost','root','','login');
	    $username=sanitize($username);
	    $query=mysqli_query($conn,"SELECT user_id FROM users WHERE username = '$username'");
	    $fetcharray=mysqli_fetch_array($query,MYSQLI_NUM);
	    return $fetcharray[0];
	}

	function user_id_from_email($email) {
	    $conn= mysqli_connect('localhost','root','','login');
	    $username=sanitize($email);
	    $query=mysqli_query($conn,"SELECT user_id FROM users WHERE email = '$email'");
	    $fetcharray=mysqli_fetch_array($query,MYSQLI_NUM);
	    return $fetcharray[0];
	}



	function login($username,$password) {
	    $conn= mysqli_connect('localhost','root','','login');
	    $user_id=user_id_from_username($username);

	    $username=sanitize($username);
	    $password=md5($password);

	    $query=mysqli_query($conn,"SELECT * FROM users WHERE username= '$username' AND password='$password'");
	    $result=mysqli_num_rows($query);
	    return ($result==1) ? $user_id :false;
	}


	?>
