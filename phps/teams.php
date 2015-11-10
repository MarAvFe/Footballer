<?php
session_start();

if(!isset($_SESSION['loggedUser'])){
    $newURL = 'index.php';
    header('Location: '.$newURL);
}

$conn = new mysqli($_SESSION['server'], $_SESSION['username'], $_SESSION['password'], $_SESSION['dbname']);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_POST['newTeam'])){
    $teamCountry = $_POST['teamCountry'];
    
    $sql = "select mydb.getCountryName(".$teamCountry.");";
    $result = $conn->query($sql);
    $row = $result->fetch_row();
    
    $teamCap = $_POST['teamCap'];
    $teamName = $row[0];
    $teamCoach = $_POST['teamCoach'];
    
    $sql = "call mydb.insertTeam('".$teamName."',".$teamCap.",".$teamCoach.",".$teamCountry.");";
    $conn->query($sql);
    
}

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
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.7/angular.min.js"></script>
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
            <li class="active">
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
              <h1 class="text-center">Teams</h1>
            </div>
          </div>
        </div>
          <button type="button" class="btn btn-block btn-info btn-lg" data-target="#addStadiumForm" data-toggle="collapse">Add a new team
          <i class="fa fa-fw fa-lg fa-plus-circle"></i>
        </button>
        <br>
        <div id="addStadiumForm" ng-app="" class="collapse">
          <div class="row">
            <div class="col-md-12">
              <form class="form-horizontal" role="form" method="post" action="teams.php">
                <div class="form-group">
                  <div class="col-sm-offset-3 col-sm-1">
                    <label class="control-label">Flag</label>
                  </div>
                  <div class="col-sm-8">
                    <input type="file" name="teamFlag">
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-offset-3 col-sm-1">
                    <label class="control-label">Captain</label>
                  </div>
                  <div class="col-sm-8">
                    <select class="selectpicker" data-width="100%" data-live-search="true" title="Captain" name="teamCap">
                        <?php 
                            $sql = "select pla.idPlayer, concat(per.firstName, ' ', per.lastName) from mydb.Player pla, mydb.Person per where pla.idPerson = per.idPerson;";
                            $result = $conn->query($sql);
                            if (!$result) {
                                echo 'Could not run query: ' . mysql_error();
                            }
                            while($row = $result->fetch_row()){
                                echo "<option value='".$row[0]."'>".$row[1]."</option>";
                            }
                        ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-offset-3 col-sm-1">
                    <label class="control-label">Coach</label>
                  </div>
                  <div class="col-sm-8">
                    <select class="selectpicker" data-width="100%" data-live-search="true" title="Coach" name="teamCoach">
                        <?php 
                            $sql = "select pla.idCoach, concat(per.firstName, ' ', per.lastName) from mydb.Coach pla, mydb.Person per where pla.idPerson = per.idPerson;";
                            $result = $conn->query($sql);
                            if (!$result) {
                                echo 'Could not run query: ' . mysql_error();
                            }
                            while($row = $result->fetch_row()){
                                echo "<option value='".$row[0]."'>".$row[1]."</option>";
                            }
                        ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-offset-3 col-sm-1">
                    <label class="control-label">Countries</label>
                  </div>
                  <div class="col-sm-8">
                    <select class="selectpicker" ng-model="countryNameVal" data-width="100%" data-live-search="true" title="Countries" name="teamCountry">
                        <?php 
                            $sql = "Select idCountry, nameCountry from mydb.Country;";
                            $result = $conn->query($sql);
                            if (!$result) {
                                echo 'Could not run query: ' . mysql_error();
                            }
                            while($row = $result->fetch_row()){
                                echo "<option value='".$row[0]."'>".$row[1]."</option>";
                            }
                        ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-offset-4 col-sm-8">
                    <button name="newTeam" type="submit" class="btn btn-success">Add team</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <h3>Africa</h3>
            
            <table class="table">
              <thead>
                <tr>
                  <th>Flag</th>
                  <th>Name</th>
                  <th># Players</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    <img src="img/flags/angola.png" height="40" width="70" class="img-responsive">
                  </td>
                  <td><a href="team.php">Angola</a></td>
                  <td>19</td>
                </tr>
                <tr>
                  <td>
                    <img src="img/flags/nigeria.png" height="40" width="70" class="img-responsive">
                  </td>
                  <td>Nigeria</td>
                  <td>22</td>
                </tr>
                <tr>
                  <td>
                    <img src="img/flags/togo.png" height="40" width="70" class="img-responsive">
                  </td>
                  <td>Togo</td>
                  <td>23</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="col-md-12">
            <h3>America</h3>
            <table class="table">
              <thead>
                <tr>
                  <th>Flag</th>
                  <th>Name</th>
                  <th># Players</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    <img src="img/flags/angola.png" height="40" width="70" class="img-responsive">
                  </td>
                  <td>Angola</td>
                  <td>19</td>
                </tr>
                <tr>
                  <td>
                    <img src="img/flags/nigeria.png" height="40" width="70" class="img-responsive">
                  </td>
                  <td>Nigeria</td>
                  <td>22</td>
                </tr>
                <tr>
                  <td>
                    <img src="img/flags/togo.png" height="40" width="70" class="img-responsive">
                  </td>
                  <td>Togo</td>
                  <td>23</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="col-md-12">
            <h3>Europe</h3>
            <table class="table">
              <thead>
                <tr>
                  <th>Flag</th>
                  <th>Name</th>
                  <th># Players</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    <img src="img/flags/angola.png" height="40" width="70" class="img-responsive">
                  </td>
                  <td>Angola</td>
                  <td>19</td>
                </tr>
                <tr>
                  <td>
                    <img src="img/flags/nigeria.png" height="40" width="70" class="img-responsive">
                  </td>
                  <td>Nigeria</td>
                  <td>22</td>
                </tr>
                <tr>
                  <td>
                    <img src="img/flags/togo.png" height="40" width="70" class="img-responsive">
                  </td>
                  <td>Togo</td>
                  <td>23</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="col-md-12">
            <h3>Asia</h3>
            <table class="table">
              <thead>
                <tr>
                  <th>Flag</th>
                  <th>Name</th>
                  <th># Players</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    <img src="img/flags/angola.png" height="40" width="70" class="img-responsive">
                  </td>
                  <td>Angola</td>
                  <td>19</td>
                </tr>
                <tr>
                  <td>
                    <img src="img/flags/nigeria.png" height="40" width="70" class="img-responsive">
                  </td>
                  <td>Nigeria</td>
                  <td>22</td>
                </tr>
                <tr>
                  <td>
                    <img src="img/flags/togo.png" height="40" width="70" class="img-responsive">
                  </td>
                  <td>Togo</td>
                  <td>23</td>
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
  

</body></html>