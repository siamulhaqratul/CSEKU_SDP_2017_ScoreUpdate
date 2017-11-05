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
class lastbowler
{
  
	private $adminid;
  private $matchid;
	private $tossId;
  private $playerid;

	public function getlastbowler()
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
        $this->over=$value['overs'];
      }
    }

    $sql="SELECT * FROM status WHERE match_id=$this->matchid AND toss!=$this->tossId";
    $result=DB::getConnection()->select($sql);
    if($result)
    {
       foreach ($result as $value) 
       {
        
         $this->playerid=$value['player_id'];

       }
    }
    $sql="UPDATE players SET isSelect=1 WHERE player_id=$this->playerid";
    $result=DB::getConnection()->update($sql);
    header("Location:selectbowler.php");
   // header("Location:ballbyball.php");
       
	}
}
$bowler=new lastbowler();
$bowler->getlastbowler();
?>