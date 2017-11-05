<?php include'admin/core/init.php';?>
<?php
class activeMatch
{
   public function activeTeam()
   {
     $sql="SELECT * FROM m_atch WHERE isActive=1";
     return $result=DB::getConnection()->select($sql);
   }
}
$active=new activeMatch();
$result1=$active->activeTeam();
?>
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="refresh" content="5;url=http://localhost/cricinfo/liveScores.php" />
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
      foreach ($result1 as $value) 
      {
      	 $matchid=$value['match_id'];
      	 $tossid=$value['toss'];
      	 $teamAid=$value['team_Aid'];
      	 $teamBid=$value['team_Bid'];
      	 $teamAname=$value['team_Aname'];
      	 $teamBname=$value['team_Bname'];
      	 $teamAruns=0;
      	 $teamBruns=0;
      	 $teamAwickets=0;
      	 $teamBwickets=0;
      	 $extrawicket=0;
         $overs=0;
      	 echo '<div class="match">';
      	 echo "<h1><a href='details.php?match_id=" . $matchid . "'>" . $teamAname . " Vs " . $teamBname . "</a></h1>";
      	 if($tossid==$teamAid)
      	 {
      	 	echo "<p>".$teamAname." ";
      	 }
         else
         {
          echo "<p>".$teamBname." ";
         }
      	 $sql="SELECT * FROM status WHERE match_id=$matchid AND toss!=$tossid";
      	 $result2=DB::getConnection()->select($sql);
      	 if($result2)
      	 {
      	 	foreach ($result2 as $value1)
      	    {
              $teamAruns+=$value1['bowlruns'];
              $teamAwickets+=$value1['wicket'];
              $extrawicket+=$value1['extra_wicket'];
              $overs+=$value1['bowled_overs'];
      	    }
            $ov=0;
            $over=0;
            if($overs!=0)
            {
               $ov=$overs%6;
               $over=intval($overs/6);
            }
      	    $teamAwickets+=$extrawicket;
      	    echo $teamAruns." / ".$teamAwickets.' ('.
            'Ovs '.$over.'.'.$ov.')'.'</p>';
      	 }

         $sql="SELECT * FROM status WHERE match_id=$matchid AND toss=$tossid";
         $result2=DB::getConnection()->select($sql);
         if($result2)
         {
          $extrawicket=0;
          $overs=0;
          foreach ($result2 as $value1)
            {
              $teamBruns+=$value1['bowlruns'];
              $teamBwickets+=$value1['wicket'];
              $extrawicket+=$value1['extra_wicket'];
              $overs+=$value1['bowled_overs'];
            }

            $ov=0;
            $over=0;
            if($overs!=0)
            {
               $ov=$overs%6;
               $over=intval($overs/6);
            }
            $teamBwickets+=$extrawicket;
            if($tossid!=$teamAid && $teamBruns>0 ||$tossid!=$teamAid && $overs>0)
            {
              echo "<p>".$teamAname." ";
              echo $teamBruns." / ".$teamBwickets.' ('.
             'Ovs '.$over.'.'.$ov.')'.'</p>';
            }
            else if($tossid!=$teamBid && $teamBruns>0 ||$tossid!=$teamAid && $overs>0)
            {
              echo "<p>".$teamBname." ";
              echo $teamBruns." / ".$teamBwickets.' ('.
             'Ovs '.$over.'.'.$ov.')'.'</p>';
            }
            
         }

      	 echo '</div>';
      }

    ?>

  	<div style="clear: both;"></div>
</section>
	
	<footer>
		<p>copyright &copy; Md. Moniruzzaman Aurangzeb</p>
	</footer>
</body>
</html>