<?php
session_start();

// Revisa si hay una sesión de administrador iniciada y redirige en caso 
// se no se así para limitar el acceso a estas funciones.
if(!isset($_SESSION['loggedUser'])){
    $newURL = 'index.php';
    header('Location: '.$newURL);
}

$conn = new mysqli($_SESSION['server'], $_SESSION['username'], $_SESSION['password'], $_SESSION['dbname']);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


/*
    Comienzan las validaciones para comprobar si algún formulario 
    ha sido llamado para insertar o eliminar algún dato
*/
if(isset($_POST['addPosition'])){
    $sql = "call mydb.insertPosition('".$_POST['inPosition']."');";
    $conn->query($sql);
}
if(isset($_POST['delPosition'])){
    $sql = "call mydb.deletePosition('".$_POST['outPosition']."');";
    $conn->query($sql);
}

if(isset($_POST['createPrize'])){
    // Se discrimina si el tipo de premio es para una persona o un equipo.
    if($_POST['awardType']){
        $sql = "call mydb.insertAwardPerson('".$_POST['prizeName']."');";
        $conn->query($sql);
    }else{
        $sql = "call mydb.insertAwardTeam('".$_POST['prizeName']."');";
        $conn->query($sql);
    }
}

if(isset($_POST['submitPrize'])){
    // Manejo de los casos de concesión de un permiso
    $awardValue = explode("-",$_POST['awardId']);
    $winnerValue = explode("-",$_POST['winnerId']);
    if($awardValue[0] == 't' and $winnerValue[0] == 't' ){
        $sql = "call mydb.insertAwardxTeam(".$awardValue[1].",".$winnerValue[1].");";
        $conn->query($sql);
    }else if($awardValue[0] == 'p' and $winnerValue[0] == 'p' ){
        $sql = "call mydb.insertAwardxPlayer(".$awardValue[1].",".$winnerValue[1].");";
        $conn->query($sql);
    }
}

if(isset($_POST['addCountry'])){
    $sql = "call mydb.insertCountry('".$_POST['inCountry']."','foto','".$_POST['inContinent']."');";
    $conn->query($sql);
}

if(isset($_POST['delCountry'])){
    $sql = "call mydb.insertCountry('".$_POST['inCountry']."','foto','".$_POST['inContinent']."');";
    //$conn->query($sql);
}

if(isset($_POST['addCity'])){
    $sql = "call mydb.insertCity('".$_POST['inCity']."','".$_POST['inCountry']."');";
    $conn->query($sql);
}

if(isset($_POST['delCountry'])){
    $sql = "call mydb.insertCountry('".$_POST['inCountry']."','foto','".$_POST['inContinent']."');";
    //$conn->query($sql);
}


if(isset($_POST['possession'])){
    // Este fragmento se encarga de la inserción de datos y estadísticas 
    // sobre un partido finalizado.
    
    $newStats = $_POST['newStat'];
    foreach ($newStats as $value) {
      echo $value . ", ";
    }
    $newStats[count($newStats)] = "";
    
    $gameId = $_POST['gameId'];
    $homeId = $_POST['homeId'];
    $visitId = $_POST['visitId'];
    $homeFouls = $_POST['homeFouls'];
    $visitFouls = $_POST['visitFouls'];
    $homePosses = $_POST['possession'];
    $homeCorners = $_POST['homeCorners'];
    $visitCorners = $_POST['visitCorners'];
    $homeAttempts = $_POST['homeAttempts'];
    $visitAttempts = $_POST['visitAttempts'];
    $homeOffsides = $_POST['homeOffsides'];
    $visitOffsides = $_POST['visitOffsides'];
    
    $sql = "call mydb.insertBallPossession(".$gameId.",".$homeId.",".$homePosses.");";
    $conn->query($sql);
    for($i = 0; $i < $homeOffsides; $i++){
        $sql = "call mydb.insertOffside(".$gameId.",".$homeId.");";
        $conn->query($sql);
    }
    for($i = 0; $i < $visitOffsides; $i++){
        $sql = "call mydb.insertOffside(".$gameId.",".$visitId.");";
        $conn->query($sql);
    }
    for($i = 0; $i < $homeFouls; $i++){
        $sql = "call mydb.insertFoul(".$gameId.",".$homeId.");";
        $conn->query($sql);
    }
    for($i = 0; $i < $visitFouls; $i++){
        $sql = "call mydb.insertFoul(".$gameId.",".$visitId.");";
        $conn->query($sql);
    }
    for($i = 0; $i < $homeCorners; $i++){
        $sql = "call mydb.insertCorner(".$gameId.",".$homeId.");";
        $conn->query($sql);
    }
    for($i = 0; $i < $visitCorners; $i++){
        $sql = "call mydb.insertCorner(".$gameId.",".$visitId.");";
        $conn->query($sql);
    }
    for($i = 0; $i < $homeAttempt; $i++){
        $sql = "call mydb.insertAttempt(".$gameId.",".$homeId.",0);";
        $conn->query($sql);
    }
    for($i = 0; $i < $visitAttempt; $i++){
        $sql = "call mydb.insertAttempt(".$gameId.",".$visitId.",0);";
        $conn->query($sql);
    }
    
    for($i = 0; $i < count($newStats);){
        if($newStats[$i] == 'Goal'){
            $checkValue = ($newStats[$i+3] == "off") ? 1 : 0;
            $sql = "call mydb.insertGoal(".$newStats[$i+1].",".$gameId.",".$newStats[$i+2].",".$checkValue.");";
            $conn->query($sql);
            $i = $checkValue == 1 ? $i + 4 : $i + 3;
        }
        else if($newStats[$i] == 'Card'){
            $sql = "call mydb.insertCard(".$newStats[$i+1].",".$gameId.",".$newStats[$i+2].");";
            $conn->query($sql);
            $i = $i + 3;
        }
        else if($newStats[$i] == 'Save'){
            $sql = "call mydb.insertSave(".$gameId.",".$newStats[$i+1].");";
            $conn->query($sql);
            $i = $i + 2;
        }else{
            $i++;
        }
    }
	
	$sql = "call setGamePlayed(".$gameId.");";
    $conn->query($sql);
}

?>
<!--    
        Esta página tiene como fin brindar accesso al administrador del sitio, a las acciones
        que requieran privilegios como agregar información en catálogos y crear nuevos países.
        Para acceder ah ella se necesita una autenticación que será recibida en la página index. 
-->
<!DOCTYPE html5><html lang="en" ng-app=""><head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="http://pingendo.github.io/pingendo-bootstrap/themes/default/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="./css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css">
    <link href="./css/bootstrap-select.min.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="./js/bootstrap-select.min.js"></script>
    <script type="text/javascript" src="./js/bootstrap-datepicker.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.7/angular.min.js"></script>
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
        .table.statics, th{
        text-align:center;
        }
        .statType{
            background: 0;
            border: 0;
            width: 100%;
            overflow: visible;
            outline: 0;
            height: auto;
        }
    
    </style>
    <script type="text/javascript">
        
        $(function() {
            // Función que actualiza los títulos de la tabla de estadísticas 
            // según el partido que sea seleccionado
            $('.selectpicker.gameselect').on('change', function(){
                var selected = $(this).find("option:selected").val();
                var optVals = selected.split("-");
                document.getElementById("homeId").value = optVals[0];
                document.getElementById('visitId').value = optVals[1];
                document.getElementById('homeName').innerHTML = optVals[2];
                document.getElementById('visitName').innerHTML = optVals[3];
                document.getElementById('gameId').value = optVals[4];
            });

        });
        <?php 
            // Se crean los arreglos de jugadores para los distintos datos a agregar durante la página.
            $sql = "select pla.idPlayer, concat(per.firstName, ' ', per.lastName) from mydb.Player pla, mydb.Person per where pla.idPerson = per.idPerson;";
            $result = $conn->query($sql);
            if (!$result) {
                echo 'Could not run query: ' . mysql_error();
            }
            $names = "";
            $ids = "";
            while($row = $result->fetch_row()){
                $names .= '"' .$row[1]. '",';
                $ids .= $row[0] . ',';
            }
        ?>
        var queriedPlayers = [<?php echo $names; ?>];
        var queriedIds = [<?php echo $ids; ?>];
    </script>
    <script type="text/javascript" src="./js/updateCombos.js"></script>

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
              <h1 class="text-center">Administrator page</h1>
            </div>
          </div>
        </div>
          <!-- Inicia la sección de catálogos -->
        <div class="row">
          <div class="col-md-12">
            <h1>Catalogs</h1>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <table class="table">
              <thead>
                <tr>
                  <th>Parameter</th>
                  <th>Existing options</th>
                  <th>Insert space</th>
                  <th>Add option</th>
                  <th>Delete option</th>
                </tr>
              </thead>
              <tbody>
                <tr> 
                    <!-- Formulario de inserción de posiciones -->
                    <form method="post" action="adminPage.php">
                      <td>Positions</td>
                      <td>
                        <select name="outPosition" class="selectpicker" data-width="100%">
                            <?php 
                                $sql = "Select namePosition from mydb.Position;";
                                $result = $conn->query($sql);
                                if (!$result) {
                                    echo 'Could not run query: ' . mysql_error();
                                }
                                while($row = $result->fetch_row()){
                                    echo "<option>".$row[0]."</option>";
                                }
                            ?>
                        </select>
                      </td>
                      <td>
                          <div class="col-sm-12">
                        <input name="inPosition" type="text" class="form-control" placeholder="Enter position name">
                          </div>
                      </td>
                      <td>
                        <button name="addPosition" type="submit" class="btn btn-block btn-info">Add position</button>
                      </td>
                      <td>
                        <button name="delPosition" type="submit" class="btn btn-block btn-info">Delete position</button>
                      </td>
                    </form>
                </tr>
                <tr> 
                    <!-- Formulario de inserción de países -->
                    <form method="post" action="adminPage.php">
                      <td>Countries</td>
                      <td>
                        <select name="outCountry" class="selectpicker" data-width="100%">
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
                      </td>
                      <td>
                        <div class="col-sm-6">
                            <input name="inCountry" type="text" class="form-control" placeholder="New country name">
                          </div>
                        <div class="col-sm-6">
                        <select name="inContinent" class="selectpicker" data-width="100%" title="Select it's continent">
                            <?php 
                                $sql = "Select idContinent, nameContinent from mydb.Continent;";
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
                      </td>
                      <td>
                        <button name="addCountry" type="submit" class="btn btn-block btn-info">Add country</button>
                      </td>
                      <td>
                        
                      </td>
                    </form>
                </tr>
                <tr> 
                    <!-- Formulario de inserción de ciudades -->
                    <form method="post" action="adminPage.php">
                      <td>Cities</td>
                      <td>
                        <select name="outCity" class="selectpicker" data-width="100%">
                            <?php 
                                $sql = "Select idCity, nameCity from mydb.City;";
                                $result = $conn->query($sql);
                                if (!$result) {
                                    echo 'Could not run query: ' . mysql_error();
                                }
                                while($row = $result->fetch_row()){
                                    echo "<option value='".$row[0]."'>".$row[1]."</option>";
                                }
                            ?>
                        </select>
                      </td>
                      <td>
                        <div class="col-sm-6">
                            <input name="inCity" type="text" class="form-control" placeholder="New city name">
                          </div>
                        <div class="col-sm-6">
                        <select name="inCountry" class="selectpicker" data-width="100%" title="Select it's country">
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
                      </td>
                      <td>
                        <button name="addCity" type="submit" class="btn btn-block btn-info">Add city</button>
                      </td>
                      <td>
                      </td>
                    </form>
                </tr>
              </tbody>
            </table>
            <button type="button" class="btn btn-block btn-info btn-lg" data-target="#addStatsForm" data-toggle="collapse">Add game statics
              <i class="fa fa-fw fa-lg fa-plus-circle"></i>
            </button>
            <br>
            <div id="addStatsForm" class="collapse">
              <div class="row">
                <div class="col-md-offset-2 col-md-8">
                    <!-- Formulario de inserción de estadísticas de partidi -->
                  <form role="form" class="form-horizontal" method="post" action="adminPage.php">
                    <select class="selectpicker gameSelect" ng-model="gameSelect" data-live-search="true" data-width="auto" title="Select a game">
                        <?php
                            $sql = "select ev.nameEvent, hom.idTeam , vis.idTeam , hom.nameTeam , vis.nameTeam, ga.idGame from Team vis, Team hom,mydb.Event ev inner join Game ga on ga.idEvent = ev.idEvent where vis.idTeam = ga.idVisitor  and hom.idTeam = ga.idHome group by idGame , vis.NameTeam , hom.NameTeam;";
                            
                            if ($result = $conn->query($sql)) {
                                $group = '';
                                $first = 1;
                                while($row = $result->fetch_row()){
                                    if($row[0] != $group){
                                        $group = $row[0];
                                        if($first == 1){
                                            $first = 0;
                                        };
                                        echo '<optgroup label="'.$row[0].'">';
                                    };
                                    echo "<option value='".$row[1]."-".$row[2]."-".$row[3]."-".$row[4]."-".$row[5]."'>".$row[3]." - ".$row[4]."</option>";
                                }
                                echo '</optgroup>';
                            }else{
                                echo "error";
                            }
                            
                        ?>            
                      </select>
                    <table class="table statics">
                      <thead>
                        <tr>
                          <th id="homeName">Home</th>
                          <th>Stat</th>
                          <th id="visitName">Visitor</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>
                            <input type="number" class="form-control" placeholder="0" min="0" max="100" step="1" name="possession" ng-model="otherPossession">
                          </td>
                          <td>Ball possesion</td>
                          <td>
                            <input type="number" class="form-control" placeholder="0" ng-model="possession" value="{{100-otherPossession}}" readonly="">
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <input type="number" class="form-control" placeholder="0" name="homeOffsides">
                          </td>
                          <td>Offsides</td>
                          <td>
                            <input type="number" class="form-control" placeholder="0" name="visitOffsides">
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <input type="number" class="form-control" placeholder="0" name="homeFouls">
                          </td>
                          <td>Fouls</td>
                          <td>
                            <input type="number" class="form-control" placeholder="0" name="visitFouls">
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <input type="number" class="form-control" placeholder="0" name="homeCorners">
                          </td>
                          <td>Corners</td>
                          <td>
                            <input type="number" class="form-control" placeholder="0" name="visitCorners">
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <input type="number" class="form-control" placeholder="0" name="homeAttempts">
                          </td>
                          <td>Attempts</td>
                          <td>
                            <input type="number" class="form-control" placeholder="0" name="visitAttempts">
                          </td>
                        </tr>
                      </tbody>
                    </table>
                    <input type="text" hidden="hidden" name="homeId" id="homeId">
                    <input type="text" hidden="hidden" name="visitId" id="visitId">
                    <input type="text" hidden="hidden" name="gameId" id="gameId">
                    <button type="button" class="btn  btn-success" onclick="addGoal('moreStats')">Add goal</button>
                    <button type="button" class="btn  btn-success" onclick="addCard('moreStats')">Add card</button>
                    <button type="button" class="btn  btn-success" onclick="addSave('moreStats')">Add save</button>
                    <table id="moreStats" class="table">
                      <thead>
                        <tr>
                          <th>Stat type</th>
                          <th>Player</th>
                          <th>Minute</th>
                          <th>Color</th>
                          <th>Penalty</th>
                        </tr>
                      </thead>
                      <tbody></tbody>
                    </table>
                    <button type="submit" class="btn  btn-primary">Set statics</button>
                  </form>
                </div>
              </div>
            </div>
            <button type="button" class="btn btn-block btn-info btn-lg" data-target="#addAwardForm" data-toggle="collapse">Grant award
              <i class="fa fa-fw fa-lg fa-plus-circle"></i>
            </button>
            <br>
            <div id="addAwardForm" class="collapse">
              <div class="row">
                <div class="col-md-offset-2 col-md-8">
                    <!-- Formulario de concesión de premios -->
                  <form role="form" class="form-horizontal" method="post" action="adminPage.php">
                    <div class="col-lg-4">
                        <select name="awardId" data-live-search="true" data-width="auto" title="Select a winner" class="selectpicker">
                      <?php 
                            $sql = "select pla.idPlayer, concat(per.firstName, ' ', per.lastName) from mydb.Player pla, mydb.Person per where pla.idPerson = per.idPerson;";
                            $result = $conn->query($sql);
                            if (!$result) {
                                echo 'Could not run query: ' . mysql_error();
                            }
                            echo '<optgroup label="Players">';
                            while($row = $result->fetch_row()){
                                echo "<option value='p-".$row[0]."'>".$row[1]."</option>";
                            }
                            echo '</optgroup>';
                        
                            $sql = "select te.idTeam, te.nameTeam from Country co inner join Team te on co.idCountry = te.idCountry group by nameTeam , idTeam;";
                            $result = $conn->query($sql);
                            if (!$result) {
                                echo 'Could not run query: ' . mysql_error();
                            }
                            echo '<optgroup label="Teams">';
                            while($row = $result->fetch_row()){
                                echo "<option value='t-".$row[0]."'>".$row[1]."</option>";
                            }
                            echo '</optgroup>';
                        ?>
                    </select>
                        </div>
                      <div class="col-lg-5">
                    <select name="winnerId" data-live-search="true" data-width="auto" title="Select an award" class="selectpicker">
                        <?php 
                            $sql = "select idAwardTeam,nameAward from AwardTeam;";
                            if ($result = $conn->query($sql)) {
                                echo '<optgroup label="Team awards">';
                                while($row = $result->fetch_row()){
                                    echo "<option value='t-".$row[0]."'>".$row[1]."</option>";
                                }
                                echo '</optgroup>';
                            }
                        
                            $sql = "select idAwardPerson,nameAwardPerson from AwardPerson;";
                            if ($result = $conn->query($sql)) {
                                echo '<optgroup label="Player awards">';
                                while($row = $result->fetch_row()){
                                    echo "<option value='p-".$row[0]."'>".$row[1]."</option>";
                                }
                                echo '</optgroup>';
                            }
                        ?>
                    </select></div>
                      <div class="col-lg-3">
                    <button name="submitPrize" type="submit" class="btn  btn-primary">Give prize</button>
                          </div>
                    <br><br>
                  </form>
                </div>
              </div>
            </div>
            <button type="button" class="btn btn-block btn-info btn-lg" data-target="#createAwardForm" data-toggle="collapse">Create award
              <i class="fa fa-fw fa-lg fa-plus-circle"></i>
            </button>
            <br>
            <div id="createAwardForm" class="collapse">
              <div class="row">
                <div class="col-md-offset-2 col-md-8">
                    <!-- Formulario de inserción de premios -->
                  <form role="form" class="form-horizontal" method="post" action="adminPage.php">
                      <div class="col-lg-4">
                        <select name="awardType" title="Select a type" class="selectpicker form-control">
                            <option value="0">For a team</option>
                            <option value="1">For a player</option>
                        </select>
                      </div>
                      <div class="col-lg-5">
                        <input name="prizeName" type="text" class="form-control" placeholder="Give it a name">
                      </div>    
                      <div class="col-lg-3">
                        <button name="createPrize" type="submit" class="btn  btn-primary form-control">Create prize</button>
                      </div>
                    <br><br>
                  </form>
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
        $('.selectpicker').selectpicker();
    </script>
  

<?php $conn->close(); ?>
</body></html>