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
class nobyRuns
{
	private $runs;
	private $adminid;
	private $tossId;
	private $statusid;
	private $nonstriker;
  private $playedball;
  private $batrun;

	public function runs($runs)
	{
	  $this->runs=$runs;
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

    $sql="SELECT status_id FROM status WHERE stricking_role=1 AND match_id=$this->matchid AND toss!=$this->tossId";
    $result=DB::getConnection()->select($sql);
    if($result)
    {
      foreach ($result as $value) 
      {
       	$this->statusid=$value['status_id'];
        $this->allwicket=$value['wicket'];
        $this->extrawicket=$value['extra_wicket'];
      }
    }
   // echo "bowler ".$this->statusid."<br>";
    // update bowler balls and runs
    $sql ="SELECT * FROM status WHERE status_id=$this->statusid";
    $result=DB::getConnection()->select($sql);
    if ($result)
    {
      $noball;
      $bowlerrun;
      $extrarun;
      foreach ($result as $value) 
      {
        $bowlerrun=$this->runs+$value["bowlruns"];
        $noball=1+$value["noball"];
        $extrarun=1+$value["extra"];
      }
      // echo "in bowler ".$this->statusid." ".$bowlerball." ".$bowlerrun;
      $sql="UPDATE  status  SET bowlruns=$bowlerrun,extra=$extrarun,noball=$noball WHERE status_id=$this->statusid";
      $result=DB::getConnection()->update($sql);
    }
    
    $sql="SELECT * FROM status WHERE stricking_role=1 AND match_id=$this->matchid AND toss=$this->tossId";
    $result=DB::getConnection()->select($sql);
    if($result)
    {
      $six;
      $four;
      foreach ($result as $value) 
      {
        $this->statusid=$value['status_id'];
        $this->playedball=1+$value['played_ball'];
        $this->batrun=$this->runs+$value["bat_run"]-1;
        $six=1+$value['hitted_sixes'];
        $four=1+$value['hitted_fours'];
      }
      $sql="UPDATE status SET bat_run=$this->batrun,played_ball=$this->playedball WHERE status_id=$this->statusid";
      $result=DB::getConnection()->update($sql);
    //  echo $four." ".$six." ".$this->runs;
      if($this->runs==5)
      {
        $sql="UPDATE status SET hitted_fours=$four WHERE status_id=$this->statusid";
        $result=DB::getConnection()->update($sql);
      }
      if($this->runs==7)
      {
        $sql="UPDATE status SET hitted_sixes=$six WHERE status_id=$this->statusid";
        $result=DB::getConnection()->update($sql);
      }
    }
    $sql="SELECT status_id FROM status WHERE stricking_role=2  AND match_id=$this->matchid AND toss=$this->tossId";
    $result=DB::getConnection()->select($sql);
    if($result)
    {
      foreach ($result as $value) 
      {
        $this->nonstriker=$value['status_id'];
      }
    }  
   //echo $this->statusid." xxx  ".$this->nonstriker;
    // if batted runs is odd then position change of batsman
    if(($this->runs%2)==0)
    {
      $sql="UPDATE  status  SET stricking_role=2 WHERE status_id=$this->statusid";
      $result=DB::getConnection()->update($sql);
      $sql="UPDATE  status  SET stricking_role=1 WHERE status_id=$this->nonstriker";
      $result=DB::getConnection()->update($sql);
    }
  
    header("Location:gamesituation.php");
       
	}
}
$run=new nobyRuns();
$run->runs($_SESSION["element_1"]);
?>