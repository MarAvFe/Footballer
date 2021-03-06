<?php 
session_start();

$hidden = "";
if(!isset($_SESSION['loggedUser'])){
    $hidden = " style='display:none'";
    /*<?php echo $hidden; ?>*/
}

// Create connection
$conn = new mysqli($_SESSION['server'], $_SESSION['username'], $_SESSION['password'], $_SESSION['dbname']);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$idTeam = $_GET['newIdTeam'];

    // Pedir información sobre el equipo a mostrar
	if (!($resultado = $conn->query("select getTeamName('$idTeam') as res"))) {
		echo "Falló Select: (" . $conn->errno . ") " . $conn->error;
	}else{
		$fila = $resultado->fetch_assoc();
		$nameTeam = $fila['res'];
	}
	
	if (!($resultado = $conn->query("select getTeamCoach('$idTeam') as res"))) {
		echo "Falló Select: (" . $conn->errno . ") " . $conn->error;
	}else{
		$fila = $resultado->fetch_assoc();
		$nameCoach = $fila['res'];
	}
	if (!($resultado = $conn->query("select getTeamCaptain('$idTeam') as res"))) {
		echo "Falló Select: (" . $conn->errno . ") " . $conn->error;
	}else{
		$fila = $resultado->fetch_assoc();
		$nameCaptain = $fila['res'];
	}
	if (!($resultado = $conn->query("select getTeamContinent('$idTeam') as res"))) {
		echo "Falló Select: (" . $conn->errno . ") " . $conn->error;
	}else{
		$fila = $resultado->fetch_assoc();
		$nameContinent = $fila['res'];
	}
	if (!($resultado = $conn->query("select idCountry as res from Team where idTeam='$idTeam'"))) {
		echo "Falló Select: (" . $conn->errno . ") " . $conn->error;
	}else{
		$fila = $resultado->fetch_assoc();
		$idCountry = $fila['res'];
	}
	
// Manejar la inserción de un jugador existente en el equipo mostrado
if(isset($_POST["addPlayer"])){
	$idPlayer = $_POST["idPlayer"];
	$shirtNum = $_POST["shirtNum"];
	$position = $_POST["idPosition"];
		
	
	$sql = "call insertPlayer_Team('$idPlayer','$idTeam','$shirtNum','$position')";
    $result = $conn->query($sql);
    if (!$result) {
		echo 'Could not run query: ' . mysql_error();
		exit;
    }
	
}
?>
<html><head>
	<title>Team Page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="http://pingendo.github.io/pingendo-bootstrap/themes/default/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap-select.min.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="js/bootstrap-select.min.js"></script>
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
          <a href="home.html"><h4 class="navbar-text">SOCCER STATS</h4></a>
        </div>
        <div class="collapse navbar-collapse" id="navbar-ex-collapse">
          <ul class="nav navbar-nav navbar-right">
            <li>
              <a href="home.php">Home</a>
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
              <img src="uploads/flags/pic<?php echo $nameTeam ?>" class="center-block img-responsive" width="300">
              <h1 class="text-center"><?php echo $nameTeam;?></h1>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="panel panel-info">
              <div class="panel-heading">
                <h3 class="panel-title">Captain</h3>
              </div>
              <div class="panel-body">
                <p><?php echo $nameCaptain;?></p>
              </div>
            </div>
            <div class="panel panel-info">
              <div class="panel-heading">
                <h3 class="panel-title">DT</h3>
              </div>
              <div class="panel-body">
                <p><?php echo $nameCoach;?></p>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="panel panel-info">
              <div class="panel-heading">
                <h3 class="panel-title">Continent</h3>
              </div>
              <div class="panel-body">
                <p><?php echo $nameContinent;?></p>
              </div>
            </div>
            <div class="panel panel-warning">
              <div class="panel-heading">
                <h3 class="panel-title lead">Players</h3>
              </div>
                <!-- Tabla para ordenar y mostrar todos los datos sobre los jugadores que pertenezcan al equipo -->
              <div class="panel-body">
                <table class="table">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>First Name</th>
                      <th>Last Name</th>
                      <th>Position</th>
                      <th>Age</th>
                    </tr>
                  </thead>
                  <tbody>
				  
				  <?php 
                                $sql = "select pl.idPlayer,p.firstName,p.lastName from Player_team pt, Person p,  Player pl
										where (pt.idPlayer=pl.idPlayer and pt.idTeam='$idTeam') and pl.idPerson=p.idPerson;";
                                $result = $conn->query($sql);
                                if (!$result) {
                                    echo 'Could not run query: ' . mysql_error();
                                    exit;
                                }
								$contador=1;
                                while($row = $result->fetch_row()){
									$idPlayer = $row[0];
									$fname=$row[1];
									$lname=$row[2];
									
									if (!($resultado = $conn->query("select getPlayerAge('$idPlayer') as res"))) {
										echo "Falló CALL: (" . $conn->errno . ") " . $conn->error;
									}else{
										$fila = $resultado->fetch_assoc();
										$age = $fila['res'];
									}
									if (!($resultado = $conn->query("select getPlayerPosition('$idTeam','$idPlayer') as res"))) {
										echo "Falló CALL: (" . $conn->errno . ") " . $conn->error;
									}else{
										$fila = $resultado->fetch_assoc();
										$position = $fila['res'];
									}
									if (!($resultado = $conn->query("select getPlayerShirt('$idTeam','$idPlayer') as res "))) {
										echo "Falló CALL: (" . $conn->errno . ") " . $conn->error;
									}else{ 
										$fila = $resultado->fetch_assoc();
										$shirt = $fila['res'];
									}
								
                                
							
                                   
									echo'<tr>';
									  echo"<td>$shirt</td>";
									  echo"<td>$fname</td>";
									  echo"<td>$lname</td>";
									  echo"<td>$position</td>";
									  echo"<td>$age</td>";
									echo'</tr>';
									
									
								   
                                }
					
                            ?>
				  
                  </tbody>
                </table>
                <button type="button" class="btn btn-block btn-info btn-lg" data-target="#addStadiumForm" data-toggle="collapse"<?php echo $hidden; ?>>Add a new player
                  <i class="fa fa-fw fa-lg fa-plus-circle"></i>
                </button>
                <br>
                <div id="addStadiumForm" class="collapse"<?php echo $hidden; ?>>
                  <div class="row">
                    <div class="col-md-12">
                      <form role="form" class="form-horizontal" action="team.php?newIdTeam=<?php echo $idTeam; ?>" method="POST">
                        <div class="col-md-4">
                          <div class="form-group">
                            <div class="col-sm-4">
                              <label class="control-label">Player</label>
                            </div>
                            <div class="col-sm-8">
                              <select name="idPlayer" class="selectpicker" data-width="100%" data-live-search="true">
                                   <!-- Select para seleccionar un jugador existente -->
                                <?php 
                                $sql = "select pl.idPlayer,CONCAT(p.firstName,' ',p.lastName) from Person p inner join
										Player pl on p.idPerson = pl.idPerson and p.idCountry = '$idCountry' 
										where pl.idPlayer not in (select idPlayer from Player_team where idTeam = $idTeam);";
                                $result = $conn->query($sql);
                                if (!$result) {
                                    echo 'Could not run query: ' . mysql_error();
                                    exit;
                                }
                                while($row = $result->fetch_row()){
                                    echo "<option value=\"". $row[0]. "\">". $row[1] . "</option>\n";
                                }
							
                            ?>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <div class="col-sm-4">
                              <label class="control-label">Position</label>
                            </div>
                            <div class="col-sm-8">
                              <select name="idPosition" class="selectpicker" data-width="100%">
          <!-- Select para seleccionar la posición del jugador a agregar -->
                                 <?php 
                                $sql = "select idPosition,namePosition from Position;";
                                $result = $conn->query($sql);
                                if (!$result) {
                                    echo 'Could not run query: ' . mysql_error();
                                    exit;
                                }
                                while($row = $result->fetch_row()){
                                    echo "<option value=\"". $row[0]. "\">". $row[1] . "</option>\n";
                                }
                            ?>
                              </select>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-sm-12">
                              <button name="addPlayer" type="submit" class="btn btn-block btn-success">Add player</button>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <div class="col-sm-4">
                              <label class="control-label">Shirt #</label>
                            </div>
                            <div class="col-sm-8">
                              <input name="shirtNum" type="number" class="form-control" min="0" step="1" placeholder="00">
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
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