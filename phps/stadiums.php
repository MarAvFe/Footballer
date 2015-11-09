<?php 
session_start();

if(!isset($_SESSION['loggedUser'])){
    $newURL = 'index.php';
    header('Location: '.$newURL);
}

// Create connection
$conn = new mysqli($_SESSION['server'], $_SESSION['username'], $_SESSION['password'], $_SESSION['dbname']);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_POST["addStadium"])){
	echo "agregar estadio";
	$nameStadium = $_POST["nameStadium"];
	$capacity = $_POST["capacity"];
	$city = 6;
	echo $nameStadium;
	echo $capacity;
	$sql = "call insertStadium('$nameStadium','$capacity','$city')";
    $result = $conn->query($sql);
    if (!$result) {
		echo 'Could not run query: ' . mysql_error();
		exit;
    }
	
}
?>
<html><head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="http://pingendo.github.io/pingendo-bootstrap/themes/default/bootstrap.css" rel="stylesheet" type="text/css">
    <style>
      img{margin:0}
    </style>
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
            <li class="active">
              <a href="stadiums.php">Stadiums</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="section">
      <div class="container">
        <button type="button" class="btn btn-block btn-info btn-lg" data-target="#addStadiumForm" data-toggle="collapse">Add a new stadium
          <i class="fa fa-fw fa-lg fa-plus-circle"></i>
        </button>
        <br>
        <div id="addStadiumForm" class="collapse">
          <div class="row">
            <div class="col-md-12">
              <form class="form-horizontal" role="form" action="stadiums.php" method="POST">
                <div class="form-group">
                  <div class="col-sm-offset-3 col-sm-1">
                    <label class="control-label">Name</label>
                  </div>
                  <div class="col-sm-8">
                    <input name="nameStadium" type="text" class="form-control">
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-offset-3 col-sm-1">
                    <label class="control-label">Picture</label>
                  </div>
                  <div class="col-sm-8">
                    <input type="file">
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-offset-3 col-sm-1">
                    <label class="control-label">Capacity</label>
                  </div>
                  <div class="col-sm-8">
                    <input name="capacity" type="number" class="form-control" placeholder="30000">
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-offset-4 col-sm-8">
                    <button name="addStadium" type="submit" class="btn btn-success">Add stadium</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="section">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
		  <?php 
						$sql = "select nameStadium,capacity,idCity from Stadium";
                        $result = $conn->query($sql);
                        if (!$result) {
                        echo 'Could not run query: ' . mysql_error();
                        exit;
                        }
						while($row = $result->fetch_row()){
							$nameStadium = $row[0];
							$capacity = $row[1]." personas";
							$idCity = $row[2];
							if (!($resultado = $conn->query("select getCityName('$idCity') as res"))) {
							echo "Falló CALL: (" . $conn->errno . ") " . $conn->error;
							}else{
								$fila = $resultado->fetch_assoc();
								$nameCity = $fila['res'];
							}
		  
							echo"<table class=\"table\">";
							  echo'<tbody>';
								echo'<tr>';
								  echo'<td rowspan="3">';
									echo"<img alt=\"estadio\" src=\"img/bernabeu.jpeg\" height=\"120\">";
								  echo'</td>';
								  echo"<td colspan=\"2\">$nameStadium</td>";
								echo'</tr>';
								echo'<tr>';
								  echo"<td colspan=\"2\">$capacity</td>";
								echo'</tr>';
								echo'<tr>';
								  echo"<td colspan=\"2\">$nameCity</td>";
								echo'</tr>';
							  echo'</tbody>';
							echo'</table>';
			
						}
		  ?>
		  
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