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
		
	$idGame = $_GET['newIdGame'];
		
/*

        RECUPERACIÓN DE TODA LA INFORMACIÓN SOBRE EL JUEGO Y LOS EQUIPOS INVOLUCRADOS

*/
	if (!($resultado = $conn->query("select idHome,idVisitor from Game where idGame ='$idGame';"))) {
    echo "Falló CALL: (" . $conn->errno . ") " . $conn->error;
	}else{
		$fila = $resultado->fetch_assoc();
		$idHome = $fila['idHome'];
		$idVisitor = $fila['idVisitor'];
	}
	
	if (!($resultado = $conn->query("select getGameHome('$idGame') as nameTeam"))) {
    echo "Falló CALL: (" . $conn->errno . ") " . $conn->error;
	}else{
		$fila = $resultado->fetch_assoc();
		$nameHome = $fila['nameTeam'];
	}
	
	if (!($resultado = $conn->query("select getGameVisit('$idGame') as nameTeam"))) {
    echo "Falló CALL: (" . $conn->errno . ") " . $conn->error;
	}else{
		$fila = $resultado->fetch_assoc();
		$nameVisit = $fila['nameTeam'];
	}
	
	if (!($resultado = $conn->query("select getGoalsTeam('$idGame','$idHome') as res"))) {
    echo "Falló CALL: (" . $conn->errno . ") " . $conn->error;
	}else{
		$fila = $resultado->fetch_assoc();
		$goalsHome = $fila['res'];
	}
	
	if (!($result = $conn->query("select getGoalsTeam('$idGame','$idVisitor') as res"))) {
		echo "Falló CALL: (" . $conn->errno . ") " . $conn->error;
	}else{
		$fila = $result->fetch_assoc();
		$goalsVisit = $fila['res'];
	}
	
	if (!($resultado = $conn->query("select getBallPossesionHome('$idGame') as res"))) {
    echo "Falló CALL: (" . $conn->errno . ") " . $conn->error;
	}else{
		$fila = $resultado->fetch_assoc();
		$posHome = $fila['res']."%";
	}
	
	if (!($result = $conn->query("select getBallPossesionVisit('$idGame') as res"))) {
		echo "Falló CALL: (" . $conn->errno . ") " . $conn->error;
	}else{
		$fila = $result->fetch_assoc();
		$posVisit = $fila['res']."%";
	}
	
	if (!($resultado = $conn->query("select getOffsidesTeam('$idGame','$idHome') as res"))) {
    echo "Falló CALL: (" . $conn->errno . ") " . $conn->error;
	}else{
		$fila = $resultado->fetch_assoc();
		$offsidesHome = $fila['res'];
	}
	
	if (!($result = $conn->query("select getOffsidesTeam('$idGame','$idVisitor') as res"))) {
		echo "Falló CALL: (" . $conn->errno . ") " . $conn->error;
	}else{
		$fila = $result->fetch_assoc();
		$offsidesVisit = $fila['res'];
	}
	
	if (!($resultado = $conn->query("select getFoulsTeam('$idGame','$idHome') as res"))) {
    echo "Falló CALL: (" . $conn->errno . ") " . $conn->error;
	}else{
		$fila = $resultado->fetch_assoc();
		$foulsHome = $fila['res'];
	}
	
	if (!($result = $conn->query("select getFoulsTeam('$idGame','$idVisitor') as res"))) {
		echo "Falló CALL: (" . $conn->errno . ") " . $conn->error;
	}else{
		$fila = $result->fetch_assoc();
		$foulsVisit = $fila['res'];
	}
	
	if (!($resultado = $conn->query("select getTotalAttemptsTeam('$idGame','$idHome') as res"))) {
    echo "Falló CALL: (" . $conn->errno . ") " . $conn->error;
	}else{
		$fila = $resultado->fetch_assoc();
		$attemptsHome = $fila['res'];
	}
	
	if (!($result = $conn->query("select getTotalAttemptsTeam('$idGame','$idVisitor') as res"))) {
		echo "Falló CALL: (" . $conn->errno . ") " . $conn->error;
	}else{
		$fila = $result->fetch_assoc();
		$attemptsVisit = $fila['res'];
	}
	
	if (!($resultado = $conn->query("select getCornersTeam('$idGame','$idHome') as res"))) {
    echo "Falló CALL: (" . $conn->errno . ") " . $conn->error;
	}else{
		$fila = $resultado->fetch_assoc();
		$cornersHome = $fila['res'];
	}
	
	if (!($result = $conn->query("select getCornersTeam('$idGame','$idVisitor') as res"))) {
		echo "Falló CALL: (" . $conn->errno . ") " . $conn->error;
	}else{
		$fila = $result->fetch_assoc();
		$cornersVisit = $fila['res'];
	}
	
	if (!($resultado = $conn->query("select getCardsTeam('$idGame','$idHome','0') as res"))) {
    echo "Falló CALL: (" . $conn->errno . ") " . $conn->error;
	}else{
		$fila = $resultado->fetch_assoc();
		$yellowHome = $fila['res'];
	}
	
	if (!($result = $conn->query("select getCardsTeam('$idGame','$idVisitor','0') as res"))) {
		echo "Falló CALL: (" . $conn->errno . ") " . $conn->error;
	}else{
		$fila = $result->fetch_assoc();
		$yellowVisit = $fila['res'];
	}
	
	if (!($resultado = $conn->query("select getCardsTeam('$idGame','$idHome','1') as res"))) {
    echo "Falló CALL: (" . $conn->errno . ") " . $conn->error;
	}else{
		$fila = $resultado->fetch_assoc();
		$redHome = $fila['res'];
	}
	
	if (!($result = $conn->query("select getCardsTeam('$idGame','$idVisitor','1') as res"))) {
		echo "Falló CALL: (" . $conn->errno . ") " . $conn->error;
	}else{
		$fila = $result->fetch_assoc();
		$redVisit = $fila['res'];
	}
	
?>

<html><head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/updateCombos.js"></script>
    <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="http://pingendo.github.io/pingendo-bootstrap/themes/default/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap-select.min.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="js/bootstrap-select.min.js"></script>
    <script type="text/javascript" src="js/bootstrap-datepicker.js"></script>
    <style>
      .table.statics th+th, 
                                                      .table.statics td+td{
                                                      	width:50%;
                                                      }
                                                      .table.statics th, 
                                                      .table.statics td,
                                                      .table.statics th+th+th, 
                                                      .table.statics td+td+td{
                                                      	width:25%;
                                                      }
                                                      .table.statics{
                                                      text-align:center;
                                                      }
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
            <!-- Menú de navegación por la página -->
          <ul class="nav navbar-nav navbar-right">
            <li class="active">
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
              <h1 class="text-center">Game</h1>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-offset-3 col-md-6">
              <!-- Tabla que muestra de manera intuitiva los datos del partido -->
            <table class="table statics">
              <thead>
                <tr>
                  <th><?php echo $nameHome;?></th>
                  <th>Static</th>
                  <th><?php echo $nameVisit;?></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    <p class="lead"><?php echo $posHome;?></p>
                  </td>
                  <td>Ball possesion</td>
                  <td>
                    <p class="lead"><?php echo $posVisit;?></p>
                  </td>
                </tr>
                <tr>
                  <td>
                    <p class="lead"><?php echo $offsidesHome;?></p>
                  </td>
                  <td>Offsides</td>
                  <td>
                    <p class="lead"><?php echo $offsidesVisit;?></p>
                  </td>
                </tr>
                <tr>
                  <td>
                    <p class="lead"><?php echo $foulsHome;?></p>
                  </td>
                  <td>Fouls</td>
                  <td>
                    <p class="lead"><?php echo $foulsVisit;?></p>
                  </td>
                </tr>
                <tr>
                  <td>
                    <p class="lead"><?php echo $attemptsHome;?></p>
                  </td>
                  <td>Attempts</td>
                  <td>
                    <p class="lead"><?php echo $attemptsVisit;?></p>
                  </td>
                </tr>
                <tr>
                  <td>
                    <p class="lead"><?php echo $goalsHome;?></p>
                  </td>
                  <td>Goals</td>
                  <td>
                    <p class="lead"><?php echo $goalsVisit;?></p>
                  </td>
                </tr>
                <tr>
                  <td>
                    <p class="lead"><?php echo $yellowHome;?></p>
                  </td>
                  <td>Yellow cards</td>
                  <td>
                    <p class="lead"><?php echo $yellowVisit;?></p>
                  </td>
                </tr>
                <tr>
                  <td>
                    <p class="lead"><?php echo $redHome;?></p>
                  </td>
                  <td>Red cards</td>
                  <td>
                    <p class="lead"><?php echo $redVisit;?></p>
                  </td>
                </tr>
                <tr>
                  <td>
                    <p class="lead"><?php echo $cornersHome;?></p>
                  </td>
                  <td>Corners</td>
                  <td>
                    <p class="lead"><?php echo $cornersVisit;?></p>
                  </td>
                </tr>
              </tbody>
            </table>
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
    <script>
      $('.popper').popover({
                                                placement: 'right',
                                                container: 'body',
                                                html: true,
                                                content: function () {
                                                  return $(this).next('.popper-content').html();
                                                }
                                              });
                                              $('#dateSelector .input-group.date').datepicker({
                                                format: "dd/mm/yyyy",
                                                autoclose: true,
                                                todayHighlight: true
                                              });
                    $('.selectpicker').selectpicker();
    </script>
  

</body></html>