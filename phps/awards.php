<?php
session_start();

$hidden = "";
if(!isset($_SESSION['loggedUser'])){
    $hidden = " style='display:none'";
    /*<?php echo $hidden; ?>*/
}

// Se crea la conexión con el servidor
$conn = new mysqli($_SESSION['server'], $_SESSION['username'], $_SESSION['password'], $_SESSION['dbname']);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
<!--    
        Esta página tiene como fin mostrar todos los premios y sus respectivo dueño
-->
<!DOCTYPE html5><html><head>
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
          <!-- Menú de navegación por la página -->
        <div class="collapse navbar-collapse" id="navbar-ex-collapse">
          <ul class="nav navbar-nav navbar-right">
            <li>
              <a href="index.php">Home</a>
            </li>
            <li class="active">
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
              <h1 class="text-center">Awards</h1>
            </div>
          </div>
        </div>
        
      </div>
    </div>
    <div class="section">
      <div class="container">
        <div class="row">
          <div class="col-md-6 col-md-offset-3">
            <table class="table">
              <thead>
                <tr>
                  <th>Award name</th>
                  <th>Owner</th>
                </tr>
              </thead>
              <tbody>
                  <!-- Muestra todos los premios asignados -->
		<?php 
                  // Recupera la información sobre los premios de los jugadores
                $sql = "select e.idEvent,e.nameEvent,e.dateStartEvent,e.dateEndEvent, es.nameEventStructure
                        from mydb.Event e, EventStructure es
                        where e.idEventStructure=es.idEventStructure;";
                $result = $conn->query($sql);
                if (!$result) {
                    echo 'Could not run query: ' . mysql_error();
                    exit;
                }
                while($row = $result->fetch_row()){
                    $awardName=$row[0];
                    $owner = $row[1];

                    echo "<tr>";
                        echo "<td>";
                        echo "<a href=\"#\">$awardName</a>";
                        echo "</td>";
                        echo "<td>$owner</td>";
                        echo "</tr>";
                }
			
                  // Recupera la información sobre los premios de los equipos
                $sql = "select e.idEvent,e.nameEvent,e.dateStartEvent,e.dateEndEvent, es.nameEventStructure
                        from mydb.Event e, EventStructure es
                        where e.idEventStructure=es.idEventStructure;";
                $result = $conn->query($sql);
                if (!$result) {
                    echo 'Could not run query: ' . mysql_error();
                    exit;
                }
                while($row = $result->fetch_row()){
                    $awardName=$row[0];
                    $owner = $row[1];

                    echo "<tr>";
                        echo "<td>";
                        echo "<a href=\"#\">$awardName</a>";
                        echo "</td>";
                        echo "<td>$owner</td>";
                        echo "</tr>";
                }
			
		?>       
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
                                      $('#dateSelector .input-daterange.input-group').datepicker({
                                        format: "dd/mm/yyyy",
                                        autoclose: true,
                                        todayHighlight: true
                                      });
    </script>
  

</body></html>
