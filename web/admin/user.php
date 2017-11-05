<?php include 'core/init.php'; ?>
<?php
if (!Session::exists('id') && !Session::exists('name') )
{
	header('Location: ' . 'login.php');	
}
if(Session::get('role')!='super_admin')
{
   header('Location: ' . 'index.php');	
}
if (isset($_GET['made_admin']) && !empty($_GET['made_admin']))
{
	$id = $_GET['made_admin'];
	$result = DB::getConnection()->update("UPDATE admin SET role='admin' WHERE id = $id");
	
	if ($result)
	{
		echo '<p class="alert alert-success">Operation Successful</p>';
	}
	else
	{
		echo '<p class="alert alert-danger">Operation Failed.</p>';
	}
}
if (isset($_GET['remove_admin']) && !empty($_GET['remove_admin']))
{
	$id = $_GET['remove_admin'];
	$result = DB::getConnection()->update("UPDATE admin SET role=NULL WHERE id = $id");
	
	if ($result)
	{
		echo '<p class="alert alert-success">Operation Successful</p>';
	}
	else
	{
		echo '<p class="alert alert-danger">Operation Failed.</p>';
	}
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
</head>
<body>
	<nav class="navbar navbar-default">
  		<div class="container-fluid">
	    	<div class="navbar-header">
	      		<a class="navbar-brand" href="#">Score Update</a>
	    	</div>
	    	<ul class="nav navbar-nav">
	      		<li class="active"><a href="index.php">Home</a></li>
<?php
if (Session::get('role') == 'super_admin')
{
	echo '<li><a href="freeadmin.php">Create Match</a></li>';
	echo '<li><a href="user.php">Users</a></li>';
}
if (Session::get('role') != 'super_admin')
{
	echo '<li><a href="#">Direct Match</a></li>';
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
		<table class="table table-default table-hover">
			<tr>
				<th>Name</th>
				<th>Username</th>
				<th>Email</th>
				<th>Role</th>
				<th>Operation</th>
			</tr>
<?php
$result = DB::getConnection()->select("SELECT * FROM admin WHERE role != 'super_admin' OR role IS NULL");

foreach ($result as $value) {
	$output = "<tr>";
	$output .= "<td>" . $value['firstname'] . "</td>";
	$output .= "<td>" . $value['username'] . "</td>";
	$output .= "<td>" . $value['email'] . "</td>";
	$output .= "<td>" . $value['role'] . "</td>";
	$output .= "<td><a href='user.php?made_admin=" . $value['id'] . "'>Made Admin</a></td>";
	$output .= "<td><a href='user.php?remove_admin=" . $value['id'] . "'>Remove Admin</a></td>";
	$output .= "</tr>";

	echo $output;	
}
?>
		</table>		
	</div>
	<script type="text/javascript" src="resources/js/jquery-1.11.3.min.js"></script>
	<script type="text/javascript" src="resources/js/bootstrap.js"></script>
</body>
</html>