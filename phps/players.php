<?php 
session_start();

// Fragmento para hacer desaparecer el botón para agregar jugadores en caso de no se el admin
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

// Fragmento para manejar y validar el registro de un nuevo jugador y la actualización de su imagen.
if(isset($_POST["addPlayer"])){
	$idCountry = $_POST["idCountry"];
	$birthdate = $_POST["birthdatePlayer"];
	$fnamePlayer = $_POST["fnamePlayer"];
	$snamePlayer = $_POST["snamePlayer"];
	$lnamePlayer = $_POST["lnamePlayer"];
	$dniPlayer = $_POST["dniPlayer"];
	$weightPlayer = $_POST["weightPlayer"];
	$heightPlayer = $_POST["heightPlayer"];
    uploadPicture($_FILES["picture"], $dniPlayer, 1);
		
	$sql = "call insertPlayer('$dniPlayer',STR_TO_DATE('$birthdate','%d/%m/%Y'),'$fnamePlayer', '$snamePlayer','$lnamePlayer','$heightPlayer','$weightPlayer','$idCountry')";
    $result = $conn->query($sql);
    if (!$result) {
		echo 'Could not run query: ' . mysql_error();
		exit;
    }
}

// Función para facilitar la subida de una imagen al servidor
function uploadPicture($picture, $idPic, $stadPerCoaFlag){
    $uploadOk = 1;
    // stadPerCoaFlag: Stadium (0), Person (1), Coach (2), Flag (3)
    if($stadPerCoaFlag == 0){
        $target_dir = "uploads/stadiums/";
    }
    else if($stadPerCoaFlag == 1){
        $target_dir = "uploads/people/players/";
    }
    else if($stadPerCoaFlag == 2){
        $target_dir = "uploads/people/coaches/";
    }
    else if($stadPerCoaFlag == 3){
        $target_dir = "uploads/flags/";
    }
    $target_file = $target_dir . basename($picture['name']);
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION); // .png .gif .jpg
    $check = getimagesize($picture["tmp_name"]);
    if($check !== false) {
        //echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
    
    // Check file size
    if ($picture["size"] > 2000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if(!is_dir($target_dir)){
            mkdir($target_dir, 0777, true);
        }
        
        if (move_uploaded_file($picture["tmp_name"], $target_dir.'pic'.$idPic)) {
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

?>
<html><head>
	<title>Players</title>
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
            <li class="active">
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
        <button type="button" class="btn btn-block btn-info btn-lg" data-target="#addStadiumForm" data-toggle="collapse"<?php echo $hidden; ?>>Add a new player
          <i class="fa fa-fw fa-lg fa-plus-circle"></i>
        </button>
        <br>
          <!-- Formulario que recibe todos los datos sobre un nuevo jugador a crear -->
        <div id="addStadiumForm" class="collapse"<?php echo $hidden; ?>>
          <div class="row">
            <div class="col-md-12">
              <form role="form" class="form-horizontal" action="players.php" method="POST" enctype="multipart/form-data">
                <div class="col-md-4">
                  <img src="img/defaultProfile.jpg" class="center-block img-responsive">
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <div class="col-sm-4">
                      <label class="control-label">Name</label>
                    </div>
                    <div class="col-sm-8">
                      <input name="fnamePlayer" type="text" class="form-control" placeholder="John">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-4">
                      <label class="control-label">Second name</label>
                    </div>
                    <div class="col-sm-8">
                      <input name="snamePlayer" type="text" class="form-control" placeholder="Albert">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-4">
                      <label class="control-label">Last name</label>
                    </div>
                    <div class="col-sm-8">
                      <input name="lnamePlayer" type="text" class="form-control" placeholder="Doe">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-4">
                      <label class="control-label">Country</label>
                    </div>
                    <div class="col-sm-8">
                      <select name="idCountry" class="selectpicker" data-width="100%" data-live-search="true">
					  <?php 
                                $sql = "select idCountry,nameCountry from Country;";
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
                    <div class="col-sm-4">
                      <label class="control-label">Picture</label>
                    </div>
                    <div class="col-sm-8">
                      <input type="file" name="picture" id="fileToUpload">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-4">
                      <button name="addPlayer" type="submit" class="btn btn-success">Add player</button>
                    </div>
                  </div>
                </div>
                  <!-- Segunda sección del formulario -->
                <div class="col-md-4">
                  <div class="form-group">
                    <div class="col-sm-4">
                      <label class="control-label">Id number</label>
                    </div>
                    <div class="col-sm-8">
                      <input name="dniPlayer" type="text" class="form-control" placeholder="123457890">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-4">
                      <label class="control-label">Weight (Kg)</label>
                    </div>
                    <div class="col-sm-8">
                      <input name="weightPlayer" type="number" class="form-control" placeholder="80">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-4">
                      <label class="control-label">Height (cm)</label>
                    </div>
                    <div class="col-sm-8">
                      <input name="heightPlayer" type="number" class="form-control" placeholder="170">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-4">
                      <label class="control-label">Birthdate</label>
                    </div>
                    <div class="col-sm-8" id="dateSelector">
                      <!--<input type="text" class="form-control" placeholder="dd/mm/yyyy" id="datepicker">-->
                      <div class="input-group date">
                        <input name="birthdatePlayer" type="text" class="form-control" readonly="true">
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
                      <!-- Cuadrilla que despliega toda la informacion sobre cada jugador mostrado -->
                    <h1 class="text-center">Players</h1>
                    <p class="text-center lead">Hover any picture for more details</p>
                    <form role="search" class="navbar-form navbar-left input-group">
                      <div class="form-group has-warning input-group">
                        <input class="form-control input-lg" placeholder="Type something..." type="text">
                        <span class="input-group-addon">
                          <i class="-o fa fa-lg fa-search"></i>
                        </span>
                      </div>
                      <button type="button" class="btn btn-lg btn-info" onclick="location.href='coaches.php'">View coaches</button>
                    </form>
                  </div>
                </div>
                <div class="row">
				<?php 
				
                    // Recuperación de la información de cada jugador
				$sql = "select idPlayer from Player";
                        $result = $conn->query($sql);
                        if (!$result) {
                        echo 'Could not run query: ' . mysql_error();
                        exit;
                        }
                        while($row = $result->fetch_row()){ 
							$newIdPlayer = $row[0];
							
						if (!($resultado = $conn->query("select getPlayerName('$newIdPlayer') as res"))) {
						echo "Falló CALL: (" . $conn->errno . ") " . $conn->error;
						}else{
							$fila = $resultado->fetch_assoc();
							$nameplayer = $fila['res'];
						}
						if (!($resultado = $conn->query("select getPlayerDNI('$newIdPlayer') as res"))) {
						echo "Falló CALL: (" . $conn->errno . ") " . $conn->error;
						}else{
							$fila = $resultado->fetch_assoc();
							$dniplayer = $fila['res'];
						}
						if (!($resultado = $conn->query("select getPlayerCountry('$newIdPlayer') as res"))) {
						echo "Falló CALL: (" . $conn->errno . ") " . $conn->error;
						}else{
							$fila = $resultado->fetch_assoc();
							$countryplayer = $fila['res'];
						}
						if (!($resultado = $conn->query("select getPlayerAge('$newIdPlayer') as res"))) {
						echo "Falló CALL: (" . $conn->errno . ") " . $conn->error;
						}else{
							$fila = $resultado->fetch_assoc();
							$ageplayer = $fila['res']." years";
						}
						if (!($resultado = $conn->query("select getPlayerHeight('$newIdPlayer') as res"))) {
						echo "Falló CALL: (" . $conn->errno . ") " . $conn->error;
						}else{
							$fila = $resultado->fetch_assoc();
							$heightplayer = $fila['res']." cm";
						}
						if (!($resultado = $conn->query("select getPlayerWeight('$newIdPlayer') as res"))) {
						echo "Falló CALL: (" . $conn->errno . ") " . $conn->error;
						}else{
							$fila = $resultado->fetch_assoc();
							$weightplayer = $fila['res']." Kg";
						}
						
				
                            // Se imprime en pantalla la información recuperada
					echo"<div class=\"col-md-3\">";
                    echo "<a href=\"#\" data-toggle=\"popover\" data-title=\"$nameplayer\" class=\"popper\"><img src=\"uploads/people/players/pic$dniplayer\" class=\"center-block img-responsive\"></a>";
                    echo '<div class="popper-content hide">';
                    echo '<p>';
                    echo "<strong>DNI:</strong>$dniplayer";
                        echo'<br>';
                        echo"<strong>Country:</strong>$countryplayer";
						echo'<br>';
                        echo"<strong>Weight:</strong>$weightplayer";
                        echo'<br>';
                        echo"<strong>Height:</strong>$heightplayer";
                        echo'<br>';
                        echo"<strong>Age:</strong>$ageplayer</p>";
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
                        placement: 'auto right',
                        container: 'body',
                        html: true,
                        trigger: "hover",
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