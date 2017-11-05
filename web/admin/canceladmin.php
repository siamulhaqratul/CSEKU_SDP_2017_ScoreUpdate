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

class cancelAdmin
{
	private $matchid;
	public function changeAdmin($matchid)
	{
		$this->matchid=$matchid;
		$sql="UPDATE  m_atch SET admin_name='NULL',isSelect=0,adminid=NULL WHERE match_id=$this->matchid";
		$result=DB::getConnection()->update($sql);

	}
	public function getselectedMatch()
	{
		$sql="SELECT * FROM m_atch WHERE isSelect=1 AND isActive=1";
		return $result=DB::getConnection()->select($sql);

	}

}
if(isset($_GET['cancel_admin']))
{
   $match=new cancelAdmin();
   $match->changeAdmin($_GET["cancel_admin"]);
}
$match1=new cancelAdmin();
$result1= $match1->getselectedMatch();
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Select Match And Admin</title>
<link rel="stylesheet" type="text/css" href="resources/css/view.css" media="all">
<link rel="stylesheet" type="text/css" href="resources/css/bootstrap.css" media="all">
<script type="text/javascript" src="resources/js/view.js"></script>

</head>
<body id="main_body" >
	
	<img id="top" src="top.png" alt="">
	<div id="form_container">
	
		<h1><a>Select Match And Admin</a></h1>
		<div class="cancel-admin">
			<a href="selectadmin.php">Select Admin</a>	
		</div>
		<form id="index3" class="appnitro"  method="post" action="">
					<div class="form_description">
			<h2>Select Match And Admin</h2>
			<p></p>
		</div>						
			<ul >
			
					<li id="li_1" >
		
		<div>
		<table class="table table-default table-hover"> 
			<tr>
				<th>Match</th>
				<th>Admin</th>
			</tr>
			
		
	
 <?php
 if($result1){
    foreach($result1 as $value) { 
	    $output="<tr>";
		$output .="<td>" . $value['team_Aname'] . " Vs ".$value['team_Bname']."</td>";
		$output .="<td>" . $value['admin_name'] . "</td>";
		$output .="<td><a href=\"?cancel_admin=" . $value['match_id'] . "\">Cancel Admin</a></td>";
		$output .="</tr>";
	    echo $output;
    }
  }
?>
		</table> 
		</div> 
		</li>		<li class="buttons">
			    <input type="hidden" name='batsmen' />
			    
				
		</li>
			</ul>
		</form>	
		
	</div>
	<img id="bottom" src="bottom.png" alt="">
	</body>
</html>