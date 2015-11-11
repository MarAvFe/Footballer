<?php 
session_start();

// Create connection
$conn = new mysqli($_SESSION['server'], $_SESSION['username'], $_SESSION['password'], $_SESSION['dbname']);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function normalize_date($date){   
		if(!empty($date)){ 
			$var = explode('/',str_replace('-','/',$date));
			return "$var[2]/$var[1]/$var[0]"; }   
		}
		
	$idEvent = $_GET['newIdEvent'];
	
	$sql = "select e.nameEvent,e.dateStartEvent,e.dateEndEvent, es.nameEventStructure
	from mydb.Event e, EventStructure es
    where e.idEvent='$idEvent' and e.idEventStructure=es.idEventStructure;";
    $result = $conn->query($sql);
    if (!$result) {
    echo 'Could not run query: ' . mysql_error();
    exit;
    }
	$row = $result->fetch_row();
	$nameEvent = $row[0];
	$dateStart = normalize_date($row[1]);
	$dateEnd = normalize_date($row[2]);
	$nameEventStructure = $row[3];

	
?>
<html><head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="http://pingendo.github.io/pingendo-bootstrap/themes/default/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap-select.min.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="js/bootstrap-select.min.js"></script>
    <link href="css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="js/bootstrap-datepicker.js"></script>
  </head><body>
    <div class="navbar navbar-default navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-ex-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand"><img height="40" alt="Brand" src="img/SoccerStatsImgLogo.png" style="position:relative;bottom:10px;"></a>
          <a href="index.php"><h4 class="navbar-text">SOCCER STATS</h4></a>
        </div>
        <div class="collapse navbar-collapse" id="navbar-ex-collapse">
          <ul class="nav navbar-nav navbar-right">
            <li>
              <a href="index.php">Home</a>
            </li>
            <li>
              <a href="events.php">Events</a>
            </li>
            <li>
              <a href="teams.php">Teams</a>
            </li>
            <li>
              <a href="players.php">Players</a>
            </li>
            <li>
              <a href="stadiums.php">Stadiums</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="section">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="well">
              <h1 class="text-center"><?php echo $nameEvent; ?></h1>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="panel panel-info">
              <div class="panel-heading">
                <h3 class="panel-title">Structure</h3>
              </div>
              <div class="panel-body">
                <p><?php echo $nameEventStructure; ?></p>
              </div>
            </div>
            <div class="panel panel-info">
              <div class="panel-heading">
                <h3 class="panel-title">Dates</h3>
              </div>
              <div class="panel-body">
                <div class="col-lg-offset-3 col-lg-6" id="dateSelector">
                  <div class="input-daterange input-group">
                    <span class="input-group-addon">From</span>
                    <p class="input-lg form-control"><?php echo $dateStart; ?></p>
                    <span class="input-group-addon">to</span>
                    <p class="input-lg form-control"><?php echo $dateEnd; ?></p>
                    <span class="input-group-addon">
                      <i class="fa fa-fw fa-lg -circle fa-calendar"></i>
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
		  <div class="panel panel-warning">
              <div class="panel-heading">
                <h3 class="panel-title lead">Teams</h3>
              </div>
              <div class="panel-body">
                <table class="table">
                  <thead>
				  <tr>
                      <th>Team</th>
                      <th>Group</th>
                      <th>Matches played</th>
                      <th>Wins</th>
                      <th>Ties</th>
                      <th>Loses</th>
                      <th>Goals favor</th>
                      <th>Goals against</th>
                      <th>Goals average</th>
                      <th>Points</th>
                    </tr>
                  </thead>
				  <tbody>
			<?php
				$sql = "select gr.idGroup , gr.nameGroup, te.idTeam, te.nameTeam, getTeamPoints(gr.idEvent,te.idTeam) as points
						from mydb.Group gr inner join Team te on gr.idEvent ='$idEvent' and te.idGroup = gr.idGroup
						order by gr.idGroup,points DESC;";
                        $result = $conn->query($sql);
                        if (!$result) {
                        echo 'Could not run query: ' . mysql_error();
                        exit;
                        }
						$contador=1;
                        while($row = $result->fetch_row()){
							$idGroup = $row[0];
							$nameGroup = $row[1];
							$idTeam = $row[2];
							$nameTeam = $row[3];
							$points = $row[4];
							
						if (!($resultado = $conn->query("select getTeamWinsPerEvent('$idEvent','$idTeam') as res"))) {
							echo "Falló CALL: (" . $conn->errno . ") " . $conn->error;
						}else{
							$fila = $resultado->fetch_assoc();
							$wins = $fila['res'];
						}
						if (!($resultado = $conn->query("select getTeamLosesPerEvent('$idEvent','$idTeam') as res"))) {
							echo "Falló CALL: (" . $conn->errno . ") " . $conn->error;
						}else{
							$fila = $resultado->fetch_assoc();
							$loses = $fila['res'];
						}
						if (!($resultado = $conn->query("select getTeamTiesPerEvent('$idEvent','$idTeam') as res"))) {
							echo "Falló CALL: (" . $conn->errno . ") " . $conn->error;
						}else{
							$fila = $resultado->fetch_assoc();
							$ties = $fila['res'];
						}
						if (!($resultado = $conn->query("select getMatchesPlayed('$idEvent','$idTeam') as res"))) {
							echo "Falló CALL: (" . $conn->errno . ") " . $conn->error;
						}else{
							$fila = $resultado->fetch_assoc();
							$matches = $fila['res'];
						}
						 echo'<tr>';
						 echo"<td><a href=\"team.php?newIdTeam=$idTeam\">$nameTeam</a></td>";
						 echo "<td>$nameGroup</td>";
						 echo"<td>$matches</td>";
						 echo"<td>$wins</td>";
						 echo"<td>$ties</td>";
						 echo"<td>$loses</td>";
						 echo"<td>8</td>";
						 echo"<td>3</td>";
						echo"<td>5</td>";
						echo"<td>$points</td>";
						echo"</tr>";
				}
				
				
		  ?>
            
                    
                  
                    
                    
                  </tbody>
                </table>
              </div>
            </div>
            <div class="panel panel-warning">
              <div class="panel-heading">
                <h3 class="panel-title lead">Games</h3>
              </div>
              <div class="panel-body">
                <table class="table">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Team</th>
                      <th>Group</th>
                    </tr>
                  </thead>
                  <tbody>
				  <?php
					$sql = "select ev.idEvent, concat(hom.nameTeam,'-', vis.nameTeam) teamNames, ga.idGame , go.nameGroup
							from mydb.Group go ,Team vis, Team hom,mydb.Event ev inner join Game ga on ga.idEvent = '$idEvent'
							where vis.idTeam = ga.idVisitor  and hom.idTeam = ga.idHome and go.idGroup = vis.idGroup
							group by idGame , teamNames;";
                        $result = $conn->query($sql);
                        if (!$result) {
                        echo 'Could not run query: ' . mysql_error();
                        exit;
                        }
						$contador=1;
                        while($row = $result->fetch_row()){
							$nameGame = $row[1];
							$idGame= $row[2];
							$nameGroup = $row[3];
							

					echo'<tr>';
                      echo"<td>$contador</td>";
                      echo'<td>';
                        echo "<a href=\"http://localhost/html/Soccer/game.php?newIdGame=$idGame\">$nameGame</a>";
                      echo'</td>';
                      echo"<td>$nameGroup</td>";
                    echo'</tr>';
					$contador=$contador+1;
						}
				  ?>
                    
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <footer class="section section-primary">
      <div class="container">
        <div class="row">
          <div class="col-sm-6">
            <h1>Every match. Every Cup.</h1>
            <p>Remember to share the site with your friends
              <br>and keep visiting for the latest information
              <br>about all your favorite cups.</p>
          </div>
          <div class="col-sm-6">
            <p class="text-info text-right">
              <br>
              <br>
            </p>
            <div class="row">
              <div class="col-md-12 hidden-lg hidden-md hidden-sm text-left">
                <a href="#"><i class="fa fa-3x fa-fw fa-instagram text-inverse"></i></a>
                <a href="#"><i class="fa fa-3x fa-fw fa-twitter text-inverse"></i></a>
                <a href="#"><i class="fa fa-3x fa-fw fa-facebook text-inverse"></i></a>
                <a href="#"><i class="fa fa-3x fa-fw fa-github text-inverse"></i></a>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 hidden-xs text-right">
                <a href="#"><i class="fa fa-3x fa-fw text-inverse fa-comment-o"></i></a>
                <a href="#"><i class="fa fa-3x fa-fw text-inverse fa-group"></i></a>
                <a href="#"><i class="fa fa-3x fa-fw text-inverse fa-futbol-o"></i></a>
                <a href="#"><i class="fa fa-3x fa-fw hub text-inverse fa-rebel"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </footer>
  

</body></html>