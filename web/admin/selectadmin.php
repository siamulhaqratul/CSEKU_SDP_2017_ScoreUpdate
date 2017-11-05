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
class selectadmin
{
	private $matchid;
	private $adminid;
	private $adminname;
	public function match_Admin_active($matchid,$adminid)
	{
		$this->matchid=$matchid;
		$this->adminid=$adminid;
		$sql="UPDATE  admin SET isActive=1 WHERE id=$this->adminid";
		$result=DB::getConnection()->update($sql);

		$sql="SELECT username FROM admin WHERE id=$this->adminid";
		$result=DB::getConnection()->select($sql);
		if($result)
		{
			foreach ($result as $value)
			{
				$this->adminname=$value['username'];
			}
		}
		$sql="UPDATE  m_atch SET admin_name='$this->adminname',isSelect=1,adminid=$this->adminid WHERE match_id=$this->matchid";
		$result=DB::getConnection()->update($sql);
		
	}
	public function selectMatch()
	{
		$sql="SELECT * FROM m_atch WHERE isActive=1 AND isSelect=0";
		return $result=DB::getConnection()->select($sql);

	}
	public function selectAdmin()
	{
		$sql="SELECT * FROM admin WHERE isActive=0 AND role='admin'";
		return $result=DB::getConnection()->select($sql);

	}
}
if($_SERVER["REQUEST_METHOD"]=="POST")
{
   $match=new selectadmin();
   $match->match_Admin_active($_POST["element_1"],$_POST["element_2"]);
}
$match1=new selectadmin();
$result1= $match1->selectMatch();
$result2= $match1->selectAdmin();
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Select Match And Admin</title>
<link rel="stylesheet" type="text/css" href="resources/css/view.css" media="all">
<script type="text/javascript" src="resources/js/view.js"></script>

</head>
<body id="main_body" >
	
	<img id="top" src="top.png" alt="">
	<div id="form_container">
	
		<h1><a>Select Match And Admin</a></h1>
		<div class="cancel-admin">
			<a href="canceladmin.php">Cancel Admin</a>	
		</div>
		<form id="index3" class="appnitro"  method="post" action="">
					<div class="form_description">
			<h2>Select Match And Admin</h2>
			<p></p>
		</div>						
			<ul >
			
					<li id="li_1" >
		<label class="description" for="element_1">Match</label>
		<div>
		<select class="element select medium" id="element_1" name="element_1" required="required"> 
	
 <?php
    foreach($result1 as $value) { ?>
      <option value="<?= $value['match_id'] ?>"><?= $value['team_Aname']." Vs ".$value['team_Bname'] ?></option>
 <?php
    } ?>
   
		</select>
		</div> 
		</li>		<li id="li_2" >
		<label class="description" for="element_2">Admin</label>
		<div>
		<select class="element select medium" id="element_2" name="element_2" required="required"> 

 <?php
    foreach($result2 as $value) { ?>
      <option value="<?= $value['id'] ?>"><?= $value['username'] ?></option>
 <?php
    } ?>

		</select>

		</div> 
		</li>		<li class="buttons">
			    <input type="hidden" name='batsmen' />
			    
				<input id="saveForm" class="button_text" type="submit" name="submit" value="Submit" />
		</li>
			</ul>
		</form>	
		
	</div>
	<img id="bottom" src="bottom.png" alt="">
	</body>
</html>


