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
class selectRetiredBatsman
{
  
	private $adminid;
	private $tossId;
	private $statusid;
  private $striker;
	private $nonstriker;
  private $playerid;
  private $strickingrole;

	public function getRetiredBatsman()
	{
     $this->adminid=Session::get('id');
	   $sql="SELECT * FROM m_atch WHERE adminid=$this->adminid";
     $result=DB::getConnection()->select($sql);
     if($result)
     {
        foreach ($result as $value) 
       	{
       	   $this->tossId=$value['toss'];
       	}
     }
     $sql="SELECT * FROM players WHERE tem_id=$this->tossId AND isSelect=2";
     return $result=DB::getConnection()->select($sql);
     echo var_dump($result); 
        
	}

  public function setRetiredBatsman($playerid,$strickingrole)
  {
     $this->playerid=$playerid;
     $this->strickingrole=$strickingrole;
     $sql="UPDATE players SET isSelect=1 WHERE player_id=$this->playerid";
     $result=DB::getConnection()->update($sql);

     $this->adminid=Session::get('id');
     $sql="SELECT * FROM m_atch WHERE adminid=$this->adminid";
     $result=DB::getConnection()->select($sql);
     if($result)
     {
        foreach ($result as $value) 
        {
           $this->tossId=$value['toss'];
           $this->matchid=$value['match_id'];
        }
     }
     $sql="SELECT * FROM status WHERE match_id=$this->matchid AND toss=$this->tossId";
     $result=DB::getConnection()->select($sql);
     if($result)
     {
        foreach ($result as $value) 
        {
           if($value['out_type']=='not out')
           {
             $this->striker=$value['status_id'];
           }
           if($value['player_id']==$this->playerid)
           {
             $this->nonstriker=$value['status_id'];
           }
        }
     }
     if($this->strickingrole==1)
     {
       $sql="UPDATE status SET out_type='not out',stricking_role=1 WHERE status_id=$this->nonstriker";
       $result=DB::getConnection()->update($sql);
       $sql="UPDATE status SET stricking_role=2 WHERE status_id=$this->striker";
       $result=DB::getConnection()->update($sql);
     }
     else
     {
        $sql="UPDATE status SET out_type='not out',stricking_role=2 WHERE status_id=$this->nonstriker";
       $result=DB::getConnection()->update($sql);
       $sql="UPDATE status SET stricking_role=1 WHERE status_id=$this->striker";
       $result=DB::getConnection()->update($sql);
       header("Location:lastbowler.php");
     }
  }
}
if($_SERVER["REQUEST_METHOD"]=="POST")
{
  $rbatsman=new selectRetiredBatsman();
  $result=$rbatsman->setRetiredBatsman($_POST["element_1"],$_POST["elementg_2"]);
}
$rbatsman=new selectRetiredBatsman();
$result=$rbatsman->getRetiredBatsman();
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
    foreach($result as $value) { ?>
    <option value="<?= $value['player_id'] ?>"><?= $value['player_name'] ?></option>
<?php
    } ?>
    </select>
    </div> 
    </li>   <li id="li_2" >
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