<?php include 'core/init.php'; ?>
<?php
if (Session::exists('id') && Session::exists('name') )
{
	header('Location: ' . 'index.php');	
	echo Session::get('message');
	Session::set('message', null);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$username = $_POST['username'];
	$password = $_POST['password'];

	$v = new Validation();
	if ($v->check(array($username, $password)))
	{
		$sql = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
		$result = DB::getConnection()->selectFirstRow($sql);

		if ($result)
		{
			if ($result['role'] != null)
			{
				Session::set('id', $result["id"]);
				Session::set('name', $result['firstname']);
				Session::set('role', $result["role"]);
			
				header('Location: ' . 'index.php');	
			}
			else
			{
				echo '<p class="alert alert-danger">You are not active user.</p>';		
			}
			
		}
		else
		{
			echo '<p class="alert alert-danger">Username or Password is wrong.</p>';	
		}
	}
	else {
		echo '<p class="alert alert-danger">Username or Password can not be empty.</p>';
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name='viewport' content="width=device-width, initial-scale=1.0">
	<title>Login</title>
	<link type="text/css" rel="stylesheet" href="resources/css/bootstrap.css">
	<link type="text/css" rel="stylesheet" href="resources/css/style.css">
</head>
<body>
	<div class="container-fluid">
		<div class="col-md-offset-4 col-md-4">
			<h1 class="text-center">Log in</h1>
			<form action="" method="POST">
				<div class="form-group">
					<label for="username">Username</label>
					<input type="text" name="username" value="" placeholder="enter username" class="form-control"/>
				</div>
				<div class="form-group">
					<label for="password">Password</label>
					<input type="password" name="password" value="" placeholder="enter password" class="form-control"/>
				</div>
				<div class="form-group">
					<p><a href="register.php">not a member register now</a></p>
					<p><a href="forget-password.php">forget password</a></p>
				</div>
				<div class="form-group col-md-offset-5">
					<input type="submit" name="register" value="Log in" class="btn btn-primary btn-lg"/>
				</div>
			</form>
		</div>
	</div>
	<script type="text/javascript" src="resources/js/jquery-1.11.3.min.js"></script>
	<script type="text/javascript" src="resources/js/bootstrap.js"></script>
</body>
</html>


