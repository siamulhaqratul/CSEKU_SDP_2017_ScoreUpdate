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
class finishGame
{
   private $adminid;
   private $matchid;
   private $teamAid;
   private $teamBid;
   public function finish()
   {
      $this->adminid=Session::get('id');
      $sql="SELECT * FROM m_atch WHERE adminid=$this->adminid";
      $result=DB::getConnection()->select($sql);
      if($result)
      {
        foreach ($result as $value) 
        {
           $this->matchid=$value['match_id'];
           $this->teamAid=$value['team_Aid'];
           $this->teamBid=$value['team_Bid'];
        }
      }
      $sql="UPDATE status SET stricking_role=NULL WHERE toss=$this->teamAid";
      $result=DB::getConnection()->update($sql);
      $sql="UPDATE status SET stricking_role=NULL WHERE toss=$this->teamBid";
      $result=DB::getConnection()->update($sql);
      $sql="UPDATE m_atch SET isFinished=1 WHERE match_id=$this->matchid";
      $result=DB::getConnection()->update($sql);
      $sql="UPDATE admin SET isActive=0 WHERE id=$this->adminid";
      $result=DB::getConnection()->update($sql);
   }
  
}
$f=new finishGame();
$f->finish();


?>