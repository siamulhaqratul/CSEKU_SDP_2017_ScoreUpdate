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
class unsetPlayers
{
  
  private $adminid;
  private $teamAid;
  private $teamBid;
  private $tossid;
  private $matchid;
	public function change()
	{
    $this->adminid=Session::get('id');
    $sql="SELECT * FROM m_atch WHERE adminid=$this->adminid";
    $result=DB::getConnection()->select($sql);
    if($result)
    {
      foreach ($result as $value) 
      {
       	$this->teamAid=$value['team_Aid'];
       	$this->teamBid=$value['team_Bid'];
        $this->tossid=$value['toss'];
        $this->matchid=$value['match_id'];
      }
    }
   // echo $this->teamAid." ".$this->teamBid;
    $sql="UPDATE players SET isSelect=0 WHERE tem_id=$this->teamAid";
    $result=DB::getConnection()->update($sql);
    $sql="UPDATE players SET isSelect=0 WHERE tem_id=$this->teamBid";
    $result=DB::getConnection()->update($sql);
    $sql="UPDATE status SET stricking_role=NULL WHERE toss=$this->teamAid";
    $result=DB::getConnection()->update($sql);
    $sql="UPDATE status SET stricking_role=NULL WHERE toss=$this->teamBid";
    $result=DB::getConnection()->update($sql);
    if($this->teamAid==$this->tossid)
    {
      $this->tossid=$this->teamBid;
    }
    else
    {
      $this->tossid=$this->teamAid;
    }
    $sql="UPDATE m_atch SET toss=$this->tossid WHERE match_id=$this->matchid";
    $result=DB::getConnection()->update($sql);
    header("Location:selectopenningbatsman.php"); 
  }  

}

$unset=new unsetPlayers();
$unset->change();
?>