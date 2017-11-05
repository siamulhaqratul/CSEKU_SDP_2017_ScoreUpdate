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
	private $adminid;
	private $teamAid;
	private $teamBid;
	private $matchid;
	private $tossId;

	public function selectedPlayers($player1id)
	{
       $this->player1id=$player1id;
       $this->adminid=Session::get('id');

       $sql="SELECT * FROM m_atch WHERE adminid=$this->adminid";
       $result=DB::getConnection()->select($sql);
       if($result)
       {
       	  foreach ($result as $value) 
       	  {
       	  	 $this->tossId=$value['toss'];
       	  	 $this->matchid=$value['match_id'];
       	  	 $this->teamAid=$value['team_Aid'];
       	  	 $this->teamBid=$value['team_Bid'];
       	  }
       }
       if($this->teamAid==$this->tossId)
       {
       	  $this->tossId=$this->teamBid;
       }
       else
       {
       	  $this->tossId=$this->teamAid;
       }
       $sql="UPDATE players SET isSelect=0 WHERE tem_id=$this->tossId";
       $result=DB::getConnection()->update($sql);
       
       $sql="INSERT INTO status (player_id,stricking_role,match_id,toss)
             VALUES('$this->player1id',1,'$this->matchid','$this->tossId')";
       $result=DB::getConnection()->insert($sql);
       if($result)
       {
      	 header("Location:ballbyball.php");
       }
       
	}
	public function selectPlayer()
	{
       $this->adminid=Session::get('id');
       $sql="SELECT * FROM m_atch WHERE adminid=$this->adminid";
       $result=DB::getConnection()->select($sql);
       if($result)
       {
       	  foreach ($result as $value) 
       	  {
       	  	 $this->tossId=$value['toss'];
       	  	 $this->matchid=$value['match_id'];
       	  	 $this->teamAid=$value['team_Aid'];
       	  	 $this->teamBid=$value['team_Bid'];
       	  }
       }
       if($this->teamAid==$this->tossId)
       {
       	  $this->tossId=$this->teamBid;
       }
       else
       {
       	  $this->tossId=$this->teamAid;
       }
       
       $sql="SELECT * FROM players WHERE tem_id=$this->tossId AND isSelect=0";
       return $result=DB::getConnection()->select($sql);
       

	}
}

if($_SERVER["REQUEST_METHOD"]=="POST")
{
   $selectplayer=new selectPlayers();
   $selectplayer->selectedPlayers($_POST["element_1"]);

}
$selectplayer1=new selectPlayers();
$result1=$selectplayer1->selectPlayer();


?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Select Bowler</title>
<link rel="stylesheet" type="text/css" href="resources/css/view.css" media="all">
<script type="text/javascript" src="resources/js/view.js"></script>

</head>
<body id="main_body" >
	
	<img id="top" src="top.png" alt="">
	<div id="form_container">
	
		<h1><a>Select Bowler</a></h1>
    <div class="cancel-admin">
      <a href="changeadmin.php">Change Admin</a> 
    </div>
		<form id="index3" class="appnitro"  method="post" action="">
					<div class="form_description">
			<h2>Select Bowler</h2>
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
		</li>	
		<li class="buttons">
			    <input type="hidden" name='batsmen' />
			    
				<input id="saveForm" class="button_text" type="submit" name="submit" value="Submit" />
		</li>	
			</ul>
		</form>	
		
	</div>
	<img id="bottom" src="bottom.png" alt="">
	</body>
</html>