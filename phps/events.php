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

function normalize_date($date){   
		if(!empty($date)){ 
			$var = explode('/',str_replace('-','/',$date));
			return "$var[2]/$var[1]/$var[0]"; }   
		} 

?>
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
          <a href="home.html"><h4 class="navbar-text">SOCCER STATS</h4></a>
        </div>
        <div class="collapse navbar-collapse" id="navbar-ex-collapse">
          <ul class="nav navbar-nav navbar-right">
            <li>
              <a href="home.html">Home</a>
            </li>
            <li class="active">
              <a href="events.html">Events</a>
            </li>
            <li>
              <a href="teams.html">Teams</a>
            </li>
            <li>
              <a href="players.html">Players</a>
            </li>
            <li>
              <a href="stadiums.html">Stadiums</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="section">
      <div class="container">
        <button type="button" class="btn btn-block btn-info btn-lg" data-target="#addStadiumForm" data-toggle="collapse">Add a new event
          <i class="fa fa-fw fa-lg fa-plus-circle"></i>
        </button>
        <br>
        <div id="addStadiumForm" class="collapse">
          <div class="row">
            <div class="col-md-12">
              <form class="form-horizontal" role="form">
                <div class="form-group">
                  <div class="col-sm-offset-3 col-sm-1">
                    <label class="control-label">Name</label>
                  </div>
                  <div class="col-sm-8">
                    <input type="text" class="form-control">
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-offset-3 col-sm-1">
                    <label class="control-label">Start-End</label>
                  </div>
                  <div class="col-sm-8" id="dateSelector">
                    <div class="input-daterange input-group">
                      <input type="text" class="input-sm form-control" name="start" readonly="">
                      <span class="input-group-addon">to</span>
                      <input type="text" class="input-sm form-control" name="end" readonly="">
                      <span class="input-group-addon">
                        <i class="fa fa-fw fa-lg -circle fa-calendar"></i>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-offset-3 col-sm-1">
                    <label class="control-label">Structure</label>
                  </div>
                  <div class="col-sm-8">
                    <select class="selectpicker" data-width="100%">
                      <option>Cup</option>
                      <option>Crown</option>
                      <option>Hexagonal</option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-offset-3 col-sm-1">
                    <label class="control-label">Teams</label>
                  </div>
                  <div class="col-sm-8">
                    <select class="selectpicker" data-width="100%" multiple="" data-live-search="true" data-selected-text-format="count" title="Countries" data-max-options="3">
                      <option>Honduras</option>
                      <option>Portugal</option>
                      <option>Spain</option>
                      <option>Panama</option>
                      <option>USA</option>
                      <option>Angola</option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-offset-4 col-sm-8">
                    <button type="submit" class="btn btn-success">Add event</button>
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
          <div class="col-md-12">
            <table class="table">
              <thead>
                <tr>
                  <th>Event name</th>
                  <th>Event structure</th>
                  <th>Start date</th>
                  <th>End date</th>
                </tr>
              </thead>
              <tbody>

		<?php 

			$sql = "call mydb.getEvent();";
                        $result = $conn->query($sql);
                        if (!$result) {
                        echo 'Could not run query: ' . mysql_error();
                        exit;
                        }
                        while($row = $result->fetch_row()){
		        $idEvent=$row[0];
				$nameEvent = $row[1];
				$dateStart = normalize_date($row[2]);
				$dateEnd = normalize_date($row[3]);
				$nameEventStructure = $row[4];

				echo "<tr>";
		          	echo "<td>";
		          	echo "<a href=\"http://localhost/html/Soccer/event.php?newIdEvent=$idEvent\">$nameEvent</a>";
		         	echo "</td>";
		         	echo "<td>$nameEventStructure</td>";
		          	echo "<td>$dateStart</td>";
		          	echo "<td>$dateEnd</td>";
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
