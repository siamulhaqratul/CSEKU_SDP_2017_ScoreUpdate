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
class outBatsman
{
  private $run;
  private $extratype;
	private $outtype;
	private $adminid;
	private $tossId;
	private $statusid;
	private $nonstriker;
  private $bowler;
  private $bowlerid;
  private $bowlername; 
  private $batsmanid;
  private $extrawicket;


	public function out($run,$extratype,$outtype)
	{
     $this->run=$run;
     $this->extratype=$extratype;
	   $this->outtype=$outtype;

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

       $sql="SELECT * FROM status WHERE stricking_role=1  AND match_id=$this->matchid AND toss=$this->tossId";
       $result=DB::getConnection()->select($sql);
       if($result)
       {
          $playedball;
       	  foreach ($result as $value) 
       	  {
       	  	 $this->statusid=$value['status_id'];
             $playedball=1+$value['played_ball'];
       	  }
          if($this->extratype==3 ||$this->extratype==4 || $this->extratype==5)
          {
             $sql="UPDATE  status  SET played_ball=$playedball WHERE status_id=$this->statusid";
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

       $sql="SELECT * FROM status WHERE stricking_role=1  AND match_id=$this->matchid AND toss!=$this->tossId";
       $result=DB::getConnection()->select($sql);
       if($result)
       {
           $noball;
           $ballrun;
           $wideball;
           $extra;
           $bowledovers;
       	  foreach ($result as $value) 
       	  {
       	  	 $this->bowler=$value['status_id'];
             $this->extrawicket=1+$value['extra_wicket'];
             $this->wickets=1+$value['wicket'];
             $noball=1+$value['noball'];
             $wideball=$this->run+$value['wideball'];
             $ballrun=$this->run+$value['bowlruns'];
             $extra=$this->run+$value['extra'];
             $bowledovers=1+$value['bowled_overs'];
       	  }
          if($this->extratype==1 || $this->extratype==2)
          {
             $sql="UPDATE  status  SET bowlruns=$ballrun,extra=$extra,wideball=$wideball WHERE status_id=$this->bowler";
             $result=DB::getConnection()->update($sql);
          }
          else if($this->extratype==3 || $this->extratype==4)
          {
             $sql="UPDATE  status  SET bowlruns=$ballrun,extra=$extra,noball=$noball WHERE status_id=$this->bowler";
             $result=DB::getConnection()->update($sql);
          }
          else if($this->extratype==5)
          {
             $sql="UPDATE  status  SET bowlruns=$ballrun,extra=$extra,bowled_overs=$bowledovers WHERE status_id=$this->bowler";
             $result=DB::getConnection()->update($sql);
          }
       }

       $sql ="SELECT player_id FROM status WHERE status_id=$this->bowler";
       $result=DB::getConnection()->select($sql);
       if ($result)
       {
           foreach ($result as $value) 
           {
            $this->bowlerid=$value["player_id"];
           }
       }
       $sql ="SELECT player_name FROM players WHERE player_id=$this->bowlerid";
       $result=DB::getConnection()->select($sql);
       if ($result)
       {
           foreach ($result as $value) 
           {
            $this->bowlername=$value["player_name"];
           }
       }


       if($this->outtype==3)
       {
          
          $sql="UPDATE  status  SET out_type='run out',stricking_role=NULL WHERE status_id=$this->statusid";
          $result=DB::getConnection()->update($sql);
       }
       else if($this->outtype==4)
       {
          $sql="UPDATE  status  SET out_type='run out',stricking_role=NULL WHERE status_id=$this->nonstriker";
          $result=DB::getConnection()->update($sql);
       }
       else if($this->outtype==6)
       {
          $this->bowlername="stm b".$this->bowlername;
          $sql="UPDATE  status  SET out_type='$this->bowlername',stricking_role=NULL WHERE status_id=$this->statusid";
          $result=DB::getConnection()->update($sql);
       }
       else if($this->outtype==8)
       {
          $sql="UPDATE  status  SET out_type='ret',stricking_role=NULL WHERE status_id=$this->statusid";
          $result=DB::getConnection()->update($sql);

          $sql="SELECT player_id FROM status WHERE status_id=$this->statusid";
          $result=DB::getConnection()->select($sql);
          if($result)
          {
            foreach ($result as $value) 
            {
              $this->batsmanid=$value['player_id'];
            }
          }
          $sql="UPDATE  players  SET isSelect=2 WHERE player_id=$this->batsmanid";
          $result=DB::getConnection()->update($sql);

       }
       else if($this->outtype==9)
       {
          $sql="UPDATE  status  SET out_type='ret',stricking_role=NULL WHERE status_id=$this->nonstriker";
          $result=DB::getConnection()->update($sql);
          $sql="SELECT player_id FROM status WHERE status_id=$this->nonstriker";
          $result=DB::getConnection()->select($sql);
          if($result)
          {
            foreach ($result as $value) 
            {
              $this->batsmanid=$value['player_id'];
            }
          }
          $sql="UPDATE  players  SET isSelect=2 WHERE player_id=$this->batsmanid";
          $result=DB::getConnection()->update($sql);
       }
       if($this->outtype==3 || $this->outtype==4 )
       {
          $sql="UPDATE  status  SET extra_wicket=$this->extrawicket WHERE status_id=$this->bowler";
          $result=DB::getConnection()->update($sql);
          var_dump($rseult);
       }
        if($this->extratype==1 && $this->outtype==6 ||$this->extratype==2 && $this->outtype==6)
       {
          $sql="UPDATE  status  SET wicket=$this->wickets WHERE status_id=$this->bowler";
          $result=DB::getConnection()->update($sql);
         // var_dump($result);
       }
       header("Location:gamesituation.php");
       
	}
}
$run=new outBatsman();
$run->out($_SESSION["element_1"],$_SESSION["element_3"],$_SESSION["element_4"]);
?>