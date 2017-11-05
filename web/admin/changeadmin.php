<?php include'core/init.php';?>
<?php
if (!Session::exists('id') && !Session::exists('name') )
{
	header('Location: ' . 'login.php');	
}
if(Session::get('role')!='admin')
{
   header('Location: ' . 'index.php');	
}
$id=Session::get('id');
//echo $id;
$sql="SELECT match_id FROM m_atch WHERE adminid=$id";
$result=DB::getConnection()->select($sql);
//var_dump($result);
if(!$result)
{
	header('Location: ' . 'index.php');
}
class selectadmin
{
	private $adminid;
	private $adminname;
	private $padminid;
	public function match_Admin_active($adminid)
	{
		$this->adminid=$adminid;
		$this->padminid=Session::get('id');
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
		//echo $this->adminid." ".$this->adminname;
		
		$sql="UPDATE  m_atch SET admin_name='$this->adminname',adminid=$this->adminid WHERE adminid=$this->padminid";
		$result=DB::getConnection()->update($sql);
		$sql="UPDATE  admin SET isActive=0 WHERE id=$this->padminid";
		$result=DB::getConnection()->update($sql);
		Session::set('id', $this->adminid);
		Session::set('name', $this->adminname);
		Session::set('role', 'admin');
		
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
   $match->match_Admin_active($_POST["element_2"]);
}
$match1=new selectadmin();
$result2= $match1->selectAdmin();
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Change Admin</title>
<link rel="stylesheet" type="text/css" href="resources/css/view.css" media="all">
<script type="text/javascript" src="resources/js/view.js"></script>

</head>
<body id="main_body" >
	
	<img id="top" src="top.png" alt="">
	<div id="form_container">
	
		<h1><a>Change Admin</a></h1>
		<form id="index3" class="appnitro"  method="post" action="">
					<div class="form_description">
			<h2>Select Admin</h2>
			<p></p>
		</div>						
			<ul >
				<li id="li_2" >
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


