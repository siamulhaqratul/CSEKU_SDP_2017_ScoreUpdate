<?php include'admin/core/init.php';?>
<?php
 class matchDetails
 {
 	private $matchid;
 	private $tossid;
 	public function teamDetails($matchid)
 	{
 		$this->matchid=$matchid;
 		$sql="SELECT * FROM m_atch WHERE match_id=$this->matchid";
 		return $result=DB::getConnection()->select($sql);
 	}
 	public function batDetails($matchid)
 	{
 		$this->matchid=$matchid;
 		$sql="SELECT toss FROM m_atch WHERE match_id=$this->matchid";
 		$result=DB::getConnection()->select($sql);
 		//var_dump($result);
 		foreach ($result as $value) 
 		{
 			$this->tossid=$value['toss'];
 		}
 		$sql="SELECT * FROM status WHERE match_id=$this->matchid AND toss=$this->tossid";
 		return $result=DB::getConnection()->select($sql);
 	}

 	public function ballDetails($matchid)
 	{
 		$this->matchid=$matchid;
 		$sql="SELECT toss FROM m_atch WHERE match_id=$this->matchid";
 		$result=DB::getConnection()->select($sql);
 		foreach ($result as $value) 
 		{
 			$this->tossid=$value['toss'];
 		}
 		$sql="SELECT * FROM status WHERE match_id=$this->matchid AND toss!=$this->tossid";
 		return $result=DB::getConnection()->select($sql);
 	}
 	public function balDetails($matchid)
 	{
 		$this->matchid=$matchid;
 		$sql="SELECT toss FROM m_atch WHERE match_id=$this->matchid";
 		$result=DB::getConnection()->select($sql);
 		foreach ($result as $value) 
 		{
 			$this->tossid=$value['toss'];
 		}
 		$sql="SELECT DISTINCT player_id FROM status WHERE match_id=$this->matchid AND toss!=$this->tossid";
 		return $result=DB::getConnection()->select($sql);
 	}
 	public function baDetails($matchid)
 	{
 		$this->matchid=$matchid;
 		$sql="SELECT toss FROM m_atch WHERE match_id=$this->matchid";
 		$result=DB::getConnection()->select($sql);
 		foreach ($result as $value) 
 		{
 			$this->tossid=$value['toss'];
 		}
 		$sql="SELECT DISTINCT player_id FROM status WHERE match_id=$this->matchid AND toss=$this->tossid";
 		return $result=DB::getConnection()->select($sql);
 	}
 }
 $team=new matchDetails();
 $result3=$team->teamDetails($_GET['match_id']);
 $bat=new matchDetails();
 $result1=$bat->batDetails($_GET['match_id']);
 $ball=new matchDetails();
 $result2=$ball->ballDetails($_GET['match_id']);
 $bal=new matchDetails();
 $result4=$bal->balDetails($_GET['match_id']);
 $ba=new matchDetails();
 $result5=$ba->baDetails($_GET['match_id']);
 //$_SESSION['match_id']=$_GET['match_id'];
 //echo $_SESSION['match_id'];
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="refresh" content="5" />
	<title> Live Scores </title>
	<link   rel="stylesheet" href="css/style.css" type="text/css"> </link>
	
</head>
<body>
<div>
	<header>
		<h1>Live Scores</h1>
	</header>
	<nav>
	   <ul>
			<li><a href="index.php">Home</a></li>
			<li><a href="liveScores.php" ""target="_blank">Live scores</a></li>
			<li><a href="#">Schedule</a></li>
			<li><a href="#">News</a></li>
			<li><a href="#">About</a></li>

	   </ul>
	</nav>
	<section>
		<?php
		$teamAid;
		$teamBid;
		$teamAname;
		$teamBname;
		$tossid;
		$teamAruns=0;
		$teamAwicket=0;
		$teamAovers=0;
		$teamBruns=0;
		$teamBwicket=0;
		$teamBovers=0;
		$nontossid;
		$match_overs;
		if($result3)
		{
			foreach ($result3 as$value) 
		    {
		      $tossid=$value['toss'];
		      $teamAid=$value['team_Aid'];
		      $teamBid=$value['team_Bid'];
		      $match_overs=$value['overs'];
			  echo'<h2>'.$value['team_Aname'].' Vs '. $value['team_Bname'].'</h2>';
		    }
		    $sql="SELECT team_name FROM team WHERE team_id=$tossid";
		    $result=DB::getConnection()->select($sql);
		    foreach ($result as$value) 
		    {
		      $teamAname=$value['team_name'];
			  echo'<p>'.$value['team_name'];
		    }
		}
		if($result2)
		{
			
			foreach ($result2 as $value) 
			{
				$teamAruns+=$value['bowlruns'];
				$teamAwicket+=$value['wicket'];
				$teamAwicket+=$value['extra_wicket'];
				$teamAovers+=$value['bowled_overs'];
			}
			$over=$teamAovers%6;
			$ov=intval ($teamAovers/6);
			echo "  ".$teamAruns .'/'.$teamAwicket.'('.$ov.'.'.$over.')'.'</p>';
			
		}
		if($result1)
		{
			
			foreach ($result1 as $value) 
			{
				$teamBruns+=$value['bowlruns'];
				$teamBwicket+=$value['wicket'];
				$teamBwicket+=$value['extra_wicket'];
				$teamBovers+=$value['bowled_overs'];
			}
			//echo "  ".$totalruns .'/'.$totalwickets.'('.$overs.')'.'</p>';
			if($teamAid==$tossid)
			{
              $nontossid=$teamBid;

			}
			else
			{
				$nontossid=$teamAid;
			}
			$sql="SELECT team_name FROM team WHERE team_id=$nontossid";
		    $result=DB::getConnection()->select($sql);
		    foreach ($result as$value) 
		    {
		      $teamBname=$value['team_name'];
			 // echo'<p>'.$value['team_name'];
		    }
		    if($teamBovers>0|| $teamBruns>0)
			{
				
			   $run=$teamBruns-$teamAruns+1;
			  // $x=$match_overs*6;
			  // echo $run.' '.$teamBwicket.' '.$x;
			   if($run>0 && $teamAwicket<10 && $teamAovers<$match_overs*6)
			   {
			   	 echo '<p>'.$teamAname.' needs '.$run.' runs to win'.'</p>';
			   }
               
			
			   if($teamAruns>$teamBruns)
			   {
				  $teamAwicket=10-$teamAwicket;
				  echo '<p>'.$teamAname.' won by '.$teamAwicket.' wickets'.'</p>';
			   }
			   else if($match_overs*6==$teamAovers)
			   {
				  if($teamAruns>$teamBruns)
			      {
				     $teamAwicket=10-$teamAwicket;
				     echo '<p>'.$teamAname.' won by '.$teamAwicket.' wickets'.'</p>';
			      }
			      else if($teamAruns<$teamBruns)
			      {
				    $run-=1;
				    echo '<p>'.$teamBname.' won by '.$run.' runs'.'</p>';
			      }
			      else
			      {
			    	 echo '<p>'.'Match drawn'.'</p>';
			     }
			   }
		   	   else if($teamAwicket==10)
			   {
				 if($teamAruns>$teamBruns)
			     {
				    $teamAwicket=10-$teamAwicket;
				    echo '<p>'.$teamAname.' won by '.$teamAwicket.'s'.'</p>';
			     }
			     else if($teamAruns<$teamBruns)
			     {
				    $runs=$teamAruns<$teamBruns;
				    echo '<p>'.$teamBname.' won by '.$runs.'s'.'</p>';
			     }
			     else
			     {
			    	 echo '<p>'.'Match drown'.'</p>';
			     }
			   }
		   }
		}
		//<p>Australia 10-1</p>
		?>
		<table class="table">
			<tr>
			<?php 
			if($result1)
			{
				echo '<th>'.'Batsman'.'</th>'.
				'<th>'.'Dm'.'</th>'.
				'<th>'.'R'.'</th>'.
				'<th>'.'4s'.'</th>'.
				'<th>'.'6s'.'</th>'.
				'<th>'.'SR'.'</th>';
			}
			?>

			</tr>
			<tr>
			   <?php 
				if($result1)
				{

				  foreach ($result1 as  $value)
				   {
				   	  $outtype=$value['out_type'];
				   	  $playerid=$value['player_id'];
				   	  $batruns=$value['bat_run'];
				   	  $playedballs=$value['played_ball'];
				   	  $fours=$value['hitted_fours'];
				   	  $sixes=$value['hitted_sixes'];
				   	  $strickingrole=$value['stricking_role'];
				   	  if($outtype!=null)
				   	  {
				   	  	$sql="SELECT player_name FROM players WHERE player_id=$playerid";
				   	  	$result=DB::getConnection()->select($sql);
				   	  	foreach ($result as $value1) 
				   	  	{
				   	  		if($strickingrole==1)
				   	  		{
				   	  			echo '<tr>'.'<td>'. $value1['player_name'].'*'.'</td>';
				   	  		}
				   	  		else
				   	  		{
				   	  			echo '<tr>'.'<td>'. $value1['player_name'].'</td>';
				   	  		}
				   	  	   
				   	  	   echo '<td>' .$outtype.'</td>'.'<td>'.$batruns.'('.$playedballs.')'.'</td>'.'<td>'.$fours.'</td>'.'<td>'.$sixes.'</td>';
				           if($playedballs!=0)
				           {
				           	echo '<td>'.number_format((float)$batruns*100/$playedballs, 2, '.', '').'</td>';
				           }
				           else
				           {
				           	 echo '<td>'.'0'.'</td>';
				           }
				           echo'</tr>';
				           
				   	  	}
				   	  }
				   }
				}
			  ?>
			</tr>
			<tr>
				<?php

				  if($result2)
				  {
				  	echo'<th>'.'Bowler'.'</th>'.
				    '<th>'.'R'.'</th>'.
				    '<th>'.'O'.'</th>'.
				    '<th>'.'W'.'</th>'.
				    '<th>'.'WD'.'</th>'.
				    '<th>'.'NB'.'</th>'.
				    '<th>'.'ECO'.'</th>';
				  }
				
				?>

			</tr>
			<tr>
				<?php

				   if($result4)
				   {
				   	 foreach ($result4 as  $value) 
				   	 {
				   	 	$runs=0;
				   	 	$overs=0;
				   	 	$wickets=0;
				   	 	$balls=0;
				   	 	$noballs=0;
				   	 	$wideballs=0;
				   	    $playerid=$value['player_id'];
				   	 	$strickingrole;
				   	 	$sql="SELECT * FROM status WHERE player_id=$playerid AND bowled_overs>0 OR player_id=$playerid AND stricking_role=1";
				   	 	$result=DB::getConnection()->select($sql);
				   	 	//var_dump($result);
				   	   // var_dump($result);
				   	 	if($result)
				   	 	{
				   	 	   foreach ($result as $value1) 
				   	 	   {
				   	 		 $runs+=$value1['bowlruns'];
				   	 		 $overs+=$value1['bowled_overs'];
				   	 		 $wickets+=$value1['wicket'];
				   	 		 $noballs+=$value1['noball'];
				   	 		 $wideballs+=$value1['wideball'];
				   	 		 $strickingrole=$value1['stricking_role'];
				   	 	  }
				   	 	//echo $playerid;
				   	 	$sql="SELECT player_name FROM players WHERE player_id=$playerid";
				   	 	$result=DB::getConnection()->select($sql);
				   	 	//var_dump($result);
				   	 	if($result)
				   	 	{
				   	 	   foreach ($result as  $value1) 
				   	 	   {
				   	 		 echo '<tr>';
				   	 		 if($strickingrole==1)
				   	 		 {
				   	 			echo'<td>'.$value1['player_name'].'*'.'</td>';
				   	 		 }
				   	 		 else if($overs>0)
				   	 		 {
				   	 			echo'<td>'.$value1['player_name'].'</td>';
				   	 		 }
				   	 		// echo $overs." ".$ball;
				   	 		 $over=$overs%6;
				   	 		 $ov=intval ($overs/6);

				   	 		 $econ=0;
				   	 		  if($overs>0)
				   	 		   $econ=number_format((float)(($runs/$overs)*6), 2, '.', '');
				   	 		  else
				   	 		   $econ=number_format((float)($runs*6), 2, '.', '');
				   	 		 echo '<td>'.$runs.'</td>'.'<td>'.$ov.'.'.$over.'</td>'.'<td>'.$wickets.'</td>'.'<td>'.$wideballs.'</td>'.'<td>'.$noballs.'</td>'.'<td>'.$econ.'</td>';
				   	 		 echo'</tr>';
				   	 	   }
				   	 	}
				   	  }
				   	 	
				   	 	//var_dump($result);
				   	 	
				   	 }
				   }
				?>
				
			</tr>
			
		</table>










        <?php
		$teamAid;
		$teamBid;
		$teamAname;
		$teamBname;
		$tossid;
		$teamAruns=0;
		$teamAwicket=0;
		$teamAovers=0;
		$teamBruns=0;
		$teamBwicket=0;
		$teamBovers=0;
		$nontossid;
		$match_overs;
		if($result3)
		{
			foreach ($result3 as$value) 
		    {
		      $tossid=$value['toss'];
		      $teamAid=$value['team_Aid'];
		      $teamBid=$value['team_Bid'];
		      $match_overs=$value['overs'];
		    }
		    if($teamAid==$tossid)
			{
              $nontossid=$teamBid;

			}
			else
			{
				$nontossid=$teamAid;
			}
			if($result1)
		    {
			
			  foreach ($result1 as $value) 
			  {
				 $teamAovers+=$value['bowled_overs'];
			  }
		    }
		    $sql="SELECT team_name FROM team WHERE team_id=$nontossid";
		    $result=DB::getConnection()->select($sql);
		    foreach ($result as$value) 
		    {
		    	if($teamAovers>0)
			     echo'<p>'.$value['team_name'];
		    }
		}
		if($result1)
		{
			$teamAovers=0;
			foreach ($result1 as $value) 
			{
				$teamAruns+=$value['bowlruns'];
				$teamAwicket+=$value['wicket'];
				$teamAwicket+=$value['extra_wicket'];
				$teamAovers+=$value['bowled_overs'];
			}
            
			if($teamAovers>0)
			{
				$over=$teamAovers%6;
				$ov=intval($teamAovers/6);
			}
			if($teamAovers>0 || $teamAruns>0 || $teamAwicket>0)
			echo "  ".$teamAruns .'/'.$teamAwicket.'('.$ov.'.'.$over.')'.'</p>';
			
		}
		?>

		<table class="table">
			<tr>
			<?php 
			$teamAovers;
			if($result1)
		    {
			
			  foreach ($result1 as $value) 
			  {
				 $teamAovers+=$value['bowled_overs'];
			  }
		    }
			if($teamAovers)
			{
				echo '<th>'.'Batsman'.'</th>'.
				'<th>'.'Dm'.'</th>'.
				'<th>'.'R'.'</th>'.
				'<th>'.'4s'.'</th>'.
				'<th>'.'6s'.'</th>'.
				'<th>'.'SR'.'</th>';
			}
			?>

			</tr>
			<tr>
			   <?php 

			    $teamAovers;
			    if($result1)
		        {
			
			      foreach ($result1 as $value) 
			      {
				    $teamAovers+=$value['bowled_overs'];
			      }
		        }

				if($result2)
				{

				  foreach ($result2 as  $value)
				   {
				   	  $outtype=$value['out_type'];
				   	  $playerid=$value['player_id'];
				   	  $batruns=$value['bat_run'];
				   	  $playedballs=$value['played_ball'];
				   	  $fours=$value['hitted_fours'];
				   	  $sixes=$value['hitted_sixes'];
				   	  $strickingrole=$value['stricking_role'];

				   	  if($outtype!=null)
				   	  {
				   	  	$sql="SELECT player_name FROM players WHERE player_id=$playerid";
				   	  	$result=DB::getConnection()->select($sql);
				   	  	foreach ($result as $value1) 
				   	  	{
				   	  		if($teamAovers>0)
				   	  		{
                                if($strickingrole==1)
				   	  		    {
				   	  			  echo '<tr>'.'<td>'. $value1['player_name'].'*'.'</td>';
				   	  		    }
				   	  		    else
				   	  		    {
				   	  			   echo '<tr>'.'<td>'. $value1['player_name'].'</td>';
				   	  		    }
				   	  	   
				   	  	        echo '<td>' .$outtype.'</td>'.'<td>'.$batruns.'('.$playedballs.')'.'</td>'.'<td>'.$fours.'</td>'.'<td>'.$sixes.'</td>';
				                if($playedballs!=0)
				                {
				           	       echo '<td>'.number_format((float)$batruns*100/$playedballs, 2, '.', '').'</td>';
				                }
				                else
				                {
				           	      echo '<td>'.'0'.'</td>';
				                }
				               echo'</tr>';
				   	  		}   
				   	  	}
				   	  }
				   }
				}
			  ?>
			</tr>
			<tr>
				<?php

				$teamAovers=null;
			    if($result1)
		        {
			
			      foreach ($result1 as $value) 
			      {
			      	//echo $teamAovers;
				    $teamAovers+=$value['bowled_overs'];
			      }
		        }

				  if($teamAovers>0)
				  {
				  	echo'<th>'.'Bowler'.'</th>'.
				    '<th>'.'R'.'</th>'.
				    '<th>'.'O'.'</th>'.
				    '<th>'.'W'.'</th>'.
				    '<th>'.'WD'.'</th>'.
				    '<th>'.'NB'.'</th>'.
				    '<th>'.'ECO'.'</th>';
				  }
				
				?>

			</tr>
			<tr>
				<?php

				  $teamAovers=null;
			      if($result1)
		          {
			
			        foreach ($result1 as $value) 
			        {
				       $teamAovers+=$value['bowled_overs'];
			        }
		          }

				   if($result5)
				   {
				   	 foreach ($result5 as  $value) 
				   	 {
				   	 	$runs=0;
				   	 	$overs=0;
				   	 	$wickets=0;
				   	 	$balls=0;
				   	 	$noballs=0;
				   	 	$wideballs=0;
				   	    $playerid=$value['player_id'];
				   	 	$strickingrole;
				   	 	$sql="SELECT * FROM status WHERE player_id=$playerid AND bowled_overs>0";
				   	 	$result=DB::getConnection()->select($sql);
				   	  //  var_dump($result);
				   	 	if($result)
				   	 	{
				   	 	   foreach ($result as $value1) 
				   	 	   {
				   	 		  $runs+=$value1['bowlruns'];
				   	 		  $overs+=$value1['bowled_overs'];
				   	 		  $wickets+=$value1['wicket'];
				   	 		  $noballs+=$value1['noball'];
				   	 		  $wideballs+=$value1['wideball'];
				   	 		//  $strickingrole=$value['stricking_role'];

				   	 	   }
				   	 	//echo $playerid;
				   	 	   $sql="SELECT player_name FROM players WHERE player_id=$playerid";
				   	 	   $result=DB::getConnection()->select($sql);
				   	 	//var_dump($result);
				   	 	  foreach ($result as  $value1) 
				   	 	  {
				   	 		 if($teamAovers>0)
				   	 		 {
                                echo '<tr>';
				   	 		   if($overs>0)
				   	 		   {
				   	 			  echo'<td>'.$value1['player_name'].'</td>';
				   	 		   }
				   	 		   $econ=0;
				   	 		   if($overs>0)
				   	 		   $econ=number_format((float)(($runs/$overs)*6), 2, '.', '');
				   	 		   else
				   	 		  	$econ=number_format((float)($runs*6), 2, '.', '');
				   	 		  $over=$overs%6;
				   	 		 $ov=intval ($overs/6);

				   	 		   echo '<td>'.$runs.'</td>'.'<td>'.$ov.'.'.$over.'</td>'.'<td>'.$wickets.'</td>'.'<td>'.$wideballs.'</td>'.'<td>'.$noballs.'</td>'.'<td>'.$econ.'</td>';
				   	 		   echo'</tr>';
				   	 		}	
				   	 	  }
				   	 	}
				   	 	
				   	 }
				   }
				?>
				
			</tr>
			
		</table>
	</section>

</body>
</html>