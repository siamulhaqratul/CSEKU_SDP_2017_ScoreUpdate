<?php include'core/init.php';?>
<?php
if (!Session::exists('id') && !Session::exists('name') )
{
	header('Location: ' . 'login.php');	
}
if(Session::get('role')!='super_admin')
{
   header('Location: ' . 'index.php');	
}
if($_SERVER["REQUEST_METHOD"]=="POST")
{
	Session::set('ngame',$_POST['nofmatch']);
	header("Location:creatematch.php");
}

?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Team Details</title>
<link rel="stylesheet" type="text/css" href="resources/css/view.css" media="all">
<script type="text/javascript" src="resources/js/view.js"></script>
<script>
function validateForm() {
    var x = document.forms["index"]["team_name1"].value;
    if (x == "") {
        alert("Team A Name must be filled out");
        return false;
    }
}
</script>

</head>
<body id="main_body" >
	
	<img id="top" src="top.png" alt="">
	<div id="form_container">
	
		<h1><a>Games</a></h1>
		<form id="index" class="appnitro"  method="post" action="" onsubmit="return validateForm()">
					<div class="form_description">
			<h2>Today's Game Number</h2>
			<p>Please enter proper info below:</p>
		</div>						
			<ul >
			
					<li id="li_1" >
		<label class="description" for="nofmatch">Game Number </label>
		<div>
			<input id="nofmatch" name="nofmatch" class="element text medium" type="text" maxlength="255" value="" required/> 
		</div> 
		</li>	
	</ul>

					<li class="buttons">
			    <input type="hidden" name="index1"/>
			    
				<input id="saveForm" class="button_text" type="submit" name="submit" value="Submit" />
		</li>
</form>
</div>
</body>
</html>