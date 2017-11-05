<?php include'core/init.php' ?>
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
class selectPlayers
{
	private $player1id;
	private $activebatsman;
	private $strikerole;
	private $adminid;
	private $matchid;
	private $tossId;

	public function selectedPlayers($player1id,$strikerole)
	{
       $this->player1id=$player1id;
       $this->strikerole=$strikerole;
       $this->adminid=Session::get('id');

       $sql="UPDATE players SET isSelect=1 WHERE player_id=$this->player1id";
       $result=DB::getConnection()->update($sql);

       $sql="SELECT * FROM m_atch WHERE adminid=$this->adminid";
       $result=DB::getConnection()->select($sql);
       if($result)
       {
       	  foreach ($result as $value) 
       	  {
       	  	 $this->matchid=$value['match_id'];
       	  	 $this->tossId=$value['toss'];
       	  }
       }
       $sql="SELECT * FROM status WHERE match_id=$this->matchid AND toss=$this->tossId AND out_type='not out'";
       $result=DB::getConnection()->select($sql);
       if($result)
       {
       	  foreach ($result as $value) 
       	  {
       	  	 $this->activebatsman=$value['status_id'];
       	  }
       }
       if($this->strikerole==1)
       {
       	  $sql="INSERT INTO status (player_id,out_type,stricking_role,match_id,toss)
             VALUES('$this->player1id','not out',1,'$this->matchid','$this->tossId')";
           $result=DB::getConnection()->insert($sql);

           $sql="UPDATE status SET stricking_role=2 WHERE match_id=$this->matchid AND toss=$this->tossId AND status_id=$this->activebatsman";
           $result=DB::getConnection()->update($sql);
       }
       else
       {
       	   $sql="INSERT INTO status (player_id,out_type,stricking_role,match_id,toss)
             VALUES('$this->player1id','not out',2,'$this->matchid','$this->tossId')";
           $result=DB::getConnection()->insert($sql);

           $sql="UPDATE status SET stricking_role=1 WHERE match_id=$this->matchid AND toss=$this->tossId AND status_id=$this->activebatsman";
           $result=DB::getConnection()->update($sql);
       }

      	header("Location:lastbowler.php");
       
	}
	public function selectPlayer()
	{
       $this->adminid=Session::get('id');
       $sql="SELECT toss FROM m_atch WHERE adminid=$this->adminid";
       $result=DB::getConnection()->select($sql);
       if($result)
       {
       	  foreach ($result as $value) 
       	  {
       	  	 $this->tossId=$value['toss'];
       	  }
       }
       $sql="SELECT * FROM players WHERE tem_id=$this->tossId AND isSelect=0";
       return $result=DB::getConnection()->select($sql);
       

	}
}

if($_SERVER["REQUEST_METHOD"]=="POST")
{
   $selectplayer=new selectPlayers();
   $selectplayer->selectedPlayers($_POST["element_1"],$_POST["element_2"]);

}
$selectplayer1=new selectPlayers();
$result1=$selectplayer1->selectPlayer();
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>New Batsman</title>
<link rel="stylesheet" type="text/css" href="resources/css/view.css" media="all">
<script type="text/javascript" src="resources/js/view.js"></script>

</head>
<body id="main_body" >
	
	<img id="top" src="top.png" alt="">
	<div id="form_container">
	
		<h1><a>New Batsman</a></h1>
    <div class="cancel-admin">
      <a href="selectretiredbatsmanbowler.php">Select Retired Batsman</a> 
      <a href="changeadmin.php">Change Admin</a> 
    </div>
		<form id="form_23896" class="appnitro"  method="post" action="">
					<div class="form_description">
			<h2>New Batsman</h2>
			<p>This is your form description. Click here to edit.</p>
		</div>						
			<ul >
			
					<li id="li_1" >
		<label class="description" for="element_1">Select Batsman </label>
		<div>
		<select class="element select medium" id="element_1" name="element_1"> 
<?php
    foreach($result1 as $value) { ?>
    <option value="<?= $value['player_id'] ?>"><?= $value['player_name'] ?></option>
<?php
    } ?>
		</select>
		</div> 
		</li>		<li id="li_2" >
		<label class="description" for="element_2">Striking Role </label>
		<div>
		<select class="element select medium" id="element_2" name="element_2" required="required"> 
			<option value="" selected="selected"></option>
<option value="1" >Striker</option>
<option value="0" >Non Striker</option>

		</select>
		</div> 
		</li>
			
					<li class="buttons">
			    <input type="hidden" name="form_id" value="23896" />
			    
				<input id="saveForm" class="button_text" type="submit" name="submit" value="Submit" />
		</li>
			</ul>
		</form>	
	</div>
	<img id="bottom" src="bottom.png" alt="">
	</body>
</html>