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
?>
<html><head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="http://pingendo.github.io/pingendo-bootstrap/themes/default/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="js/bootstrap-datepicker.js"></script>
    <link href="css/bootstrap-select.min.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="js/bootstrap-select.min.js"></script>
    <style>
      .container.playersPics .row img{
                                width:200px;
                                height:230px;
                                margin-bottom:20px;
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
        <button type="button" class="btn btn-block btn-info btn-lg" data-target="#addStadiumForm" data-toggle="collapse">Add a new coach
          <i class="fa fa-fw fa-lg fa-plus-circle"></i>
        </button>
        <br>
        <div id="addStadiumForm" class="collapse">
          <div class="row">
            <div class="col-md-12">
              <form role="form" class="form-horizontal">
                <div class="col-md-4">
                  <img src="img/defaultProfile.jpg" class="center-block img-responsive">
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <div class="col-sm-4">
                      <label class="control-label">Name</label>
                    </div>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" placeholder="John">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-4">
                      <label class="control-label">Second name</label>
                    </div>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" placeholder="Albert">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-4">
                      <label class="control-label">Last name</label>
                    </div>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" placeholder="Doe">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-4">
                      <label class="control-label">Picture</label>
                    </div>
                    <div class="col-sm-8">
                      <input type="file">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-4">
                      <button type="submit" class="btn btn-success">Add player</button>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <div class="col-sm-4">
                      <label class="control-label">Id number</label>
                    </div>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" placeholder="1-2345-7890">
                    </div>
                  </div>
                   <div class="form-group">
                    <div class="col-sm-4">
                      <label class="control-label">Country</label>
                    </div>
                    <div class="col-sm-8">
                      <select class="selectpicker" data-width="100%" data-live-search="true">
                        <option>Mustard</option>
                        <option>Ketchup</option>
                        <option>Relish</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-4">
                      <label class="control-label">Birthdate</label>
                    </div>
                    <div class="col-sm-8" id="dateSelector">
                      <!--<input type="text" class="form-control" placeholder="dd/mm/yyyy" id="datepicker">-->
                      <div class="input-group date">
                        <input type="text" class="form-control" readonly="true">
                        <span class="input-group-addon">
                          <i class="fa fa-fw fa-lg -circle fa-calendar"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="section">
              <div class="container playersPics">
                <div class="row">
                  <div class="col-md-12">
                    <h1 class="text-center">Coaches</h1>
                    <p class="text-center lead">Click any picture for more details</p>
                    <form role="search" class="navbar-form navbar-left input-group">
                      <div class="form-group has-warning input-group">
                        <input class="form-control input-lg" placeholder="Type something..." type="text">
                        <span class="input-group-addon">
                          <i class="-o fa fa-lg fa-search"></i>
                        </span>
                      </div>
                      <button type="button" class="btn btn-lg btn-info" onclick="location.href='players.php'">View players</button>
                    </form>
                  </div>
                </div>
                <div class="row">
				<?php 
				
				$sql = "select idCoach from Coach";
                        $result = $conn->query($sql);
                        if (!$result) {
                        echo 'Could not run query: ' . mysql_error();
                        exit;
                        }
                        while($row = $result->fetch_row()){
							$newIdCoach = $row[0];
							
						if (!($resultado = $conn->query("select getCoachName('$newIdCoach') as res"))) {
						echo "Falló CALL: (" . $conn->errno . ") " . $conn->error;
						}else{
							$fila = $resultado->fetch_assoc();
							$nameCoach = $fila['res'];
						}
						if (!($resultado = $conn->query("select getCoachDNI('$newIdCoach') as res"))) {
						echo "Falló CALL: (" . $conn->errno . ") " . $conn->error;
						}else{
							$fila = $resultado->fetch_assoc();
							$dniCoach = $fila['res'];
						}
						if (!($resultado = $conn->query("select getCoachCountry('$newIdCoach') as res"))) {
						echo "Falló CALL: (" . $conn->errno . ") " . $conn->error;
						}else{
							$fila = $resultado->fetch_assoc();
							$countryCoach = $fila['res'];
						}
						if (!($resultado = $conn->query("select getCoachAge('$newIdCoach') as res"))) {
						echo "Falló CALL: (" . $conn->errno . ") " . $conn->error;
						}else{
							$fila = $resultado->fetch_assoc();
							$ageCoach = $fila['res']." years";
						}
						
				
					echo"<div class=\"col-md-3\">";
                    echo "<a href=\"#\" data-toggle=\"popover\" data-title=\"$nameCoach\" class=\"popper\"><img src=\"img/totti.jpg\" class=\"center-block img-responsive\"></a>";
                    echo '<div class="popper-content hide">';
                    echo '<p>';
                    echo "<strong>DNI:</strong>$dniCoach";
                        echo'<br>';
                        echo"<strong>Country:</strong>$countryCoach";
                        echo'<br>';
                        echo"<strong>Age:</strong>$ageCoach</p>";
                    echo'</div>';
                  echo '</div>';
						}
				?>
				
                  
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
    </script>
  

</body></html>