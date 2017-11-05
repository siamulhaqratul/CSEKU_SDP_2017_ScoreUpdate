<?php include'core/init.php'; ?>
<?php
   
   if($_SERVER["REQUEST_METHOD"]=="POST")
   {
   		$first_name = $_POST['first_name'];
   		$last_name = $_POST['last_name'];
   		$email = $_POST['email'];
   		$username = $_POST['username'];
   		$password = $_POST['password'];
   		$confirm_password = $_POST['confirm_password'];

   		$v = new Validation();
   		if ($v->check(array($first_name,$last_name,$email,$username,$password,$confirm_password)))
   		{
   			if ($password === $confirm_password)
   			{
   				$first_name = $first_name . ' ' . $last_name;
   				$sql = "INSERT INTO admin(firstname,username,password,email,role,isPresent)VALUES('$first_name','$username','$password','$email','aaa',1)";
   				$result = DB::getConnection()->insert($sql);
   				if ($result)
   				{
   					$message = '<p class="alert alert-success">Registration Successful.</p>';
   					Session::set('message',$message);
   					header('Location: login.php');
   				}
   				else
   				{
   					echo '<p class="alert alert-success">Registration Failed.</p>';
   				}
   			}
   			else
   			{
   				echo '<p class="alert alert-danger">Password must match.</p>';
   			}
   		}
   		else
   		{
   			echo '<p class="alert alert-danger">Fields can not be empty.</p>';
   		}
   }
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name='viewport' content="width=device-width, initial-scale=1.0">
	<title>Register</title>
	<link type="text/css" rel="stylesheet" href="resources/css/bootstrap.css">
	<link type="text/css" rel="stylesheet" href="resources/css/style.css">
</head>
<body>
	<div class="container-fluid">
		<div class="col-md-offset-4 col-md-5">
			<h1 class="text-center">Register</h1>
			<form action="" method="POST">
				<div class="form-group">
					<label for="first_name">First Name</label>
					<input type="text" name="first_name" value="" placeholder="enter first name" class="form-control"/>
				</div>
				<div class="form-group">
					<label for="last_name">Last Name</label>
					<input type="text" name="last_name" value="" placeholder="enter last name" class="form-control"/>
				</div>
				<div class="form-group">
					<label for="email">Email</label>
					<input type="email" name="email" value="" placeholder="enter email" class="form-control"/>
				</div>
				<div class="form-group">
					<label for="username">Username</label>
					<input type="text" name="username" value="" placeholder="enter username" class="form-control"/>
				</div>
				<div class="form-group">
					<label for="password">Password</label>
					<input type="password" name="password" value="" placeholder="enter password" class="form-control"/>
				</div>
				<div class="form-group">
					<label for="confirm_password">Confirm Password</label>
					<input type="password" name="confirm_password" value="" placeholder="enter password again" class="form-control"/>
				</div>
				<div class="form-group col-md-offset-5">
					<input type="submit" name="register" value="Register" class="btn btn-primary btn-lg"/>
				</div>
			</form>
		</div>
	</div>
	<script type="text/javascript" src="resources/js/jquery-1.11.3.min.js"></script>
	<script type="text/javascript" src="resources/js/bootstrap.js"></script>
</body>
</html>