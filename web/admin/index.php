<?php include 'core/init.php'; 
if (!Session::exists('id') && !Session::exists('name') )
{
	header('Location: ' . 'login.php');	
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin Panel</title>
	<link rel="stylesheet" href="resources/css/bootstrap.css">
    <link rel="stylesheet" href="resources/css/style.css">
    <link rel="stylesheet" href="resources/css/view.css">
</head>
<body>
	<nav class="navbar navbar-default">
  		<div class="container-fluid">
	    	<div class="navbar-header">
	      		<a class="navbar-brand" href="#">Score Update</a>
	    	</div>
	    	<ul class="nav navbar-nav">
	      		<li class="active"><a href="#">Home</a></li>
<?php
if (Session::get('role') == 'super_admin')
{
	echo '<li><a href="selectadmin.php">Assign Admin</a></li>';
	echo '<li><a href="freeadmin.php">Create Match</a></li>';
	echo '<li><a href="user.php">Users</a></li>';
}
if (Session::get('role') != 'super_admin')
{
	echo '<li><a href="checkisadminisselected.php">Direct Match</a></li>';
}
?>
	    	</ul>
	    	<ul class="nav navbar-nav navbar-right">
	      		<li><a href="#"><span class="glyphicon glyphicon-user"></span><?php echo Session::get('name');?></a></li>
	      		<li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span>Logout</a></li>
	    	</ul>
  		</div>
	</nav>
	<div class="container">
		
	</div>
	<script type="text/javascript" src="resources/js/jquery-1.11.3.min.js"></script>
	<script type="text/javascript" src="resources/js/bootstrap.js"></script>
	<script type="text/javascript" src="resources/js/view.js"></script>
	
</body>
</html>