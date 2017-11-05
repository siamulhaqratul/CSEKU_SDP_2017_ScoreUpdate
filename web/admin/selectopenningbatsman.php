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
	private $player2id;
	private $adminid;
	private $matchid;
	private $tossId;

	public function selectedPlayers($player1id,$player2id)
	{
       $this->player1id=$player1id;
       $this->player2id=$player2id;
       $this->adminid=Session::get('id');

       $sql="UPDATE players SET isSelect=1 WHERE player_id=$this->player1id";
       $result=DB::getConnection()->update($sql);
       $sql="UPDATE players SET isSelect=1 WHERE player_id=$this->player2id";
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

       $sql="INSERT INTO status (player_id,out_type,stricking_role,match_id,toss)
             VALUES('$this->player1id','not out',1,'$this->matchid','$this->tossId')";
       $result=DB::getConnection()->insert($sql);

       $sql="INSERT INTO status (player_id,out_type,stricking_role,match_id,toss)
             VALUES('$this->player2id','not out',2,'$this->matchid','$this->tossId')";
       $result=DB::getConnection()->insert($sql);
      if($result)
      {
      	header("Location:selectbowler.php");
      }
       
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
<title>Select Match And Admin</title>
<link rel="stylesheet" type="text/css" href="resources/css/view.css" media="all">
<script type="text/javascript" src="resources/js/view.js"></script>

</head>
<body id="main_body" >
	
	<img id="top" src="top.png" alt="">
	<div id="form_container">
	
		<h1><a>Select Opening Batsman</a></h1>
		<div class="cancel-admin">
      <a href="changeadmin.php">Change Admin</a> 
    </div>
		<form id="index3" class="appnitro"  method="post" action="">
					<div class="form_description">
			<h2>Select Opening Batsman</h2>
			<p></p>
		</div>						
			<ul >
			
					<li id="li_1" >
		<label class="description" for="element_1">Striker</label>
		<div>
		<select class="element select medium" id="element_1" name="element_1" required="required"> 
	
 <?php
    foreach($result1 as $value) { ?>
      <option value="<?= $value['player_id'] ?>"><?= $value['player_name'] ?></option>
 <?php
    } ?>
   
		</select>
		</div> 
		</li>		<li id="li_2" >
		<label class="description" for="element_2">Nonstriker</label>
		<div>
		<select class="element select medium" id="element_2" name="element_2" required="required"> 

 <?php
    foreach($result1 as $value) { ?>
      <option value="<?= $value['player_id'] ?>"><?= $value['player_name'] ?></option>
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