<?php 
session_start();

// Determina si existe una sesión iniciada para saber qué tanto detalle de la página mostrar.
$hidden = "";
if(!isset($_SESSION['loggedUser'])){
    $hidden = " style='display:none'";
    /*<?php echo $hidden; ?>*/
}

$conn = new mysqli($_SESSION['server'], $_SESSION['username'], $_SESSION['password'], $_SESSION['dbname']);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fragmento que maneja la captura de datos y creación de un nuevo entrenador.
if(isset($_POST["addCoach"])){
	$idCountry = $_POST["idCountry"];
	$birthdate = $_POST["birthdate"];
	$fname = $_POST["fnameCoach"];
	$sname = $_POST["snameCoach"];
	$lname = $_POST["lnameCoach"];
	$dni = $_POST["dniCoach"];		
    uploadPicture($_FILES["picture"], $dni, 2);
	
	$sql = "call insertCoach('$dni',STR_TO_DATE('$birthdate','%d/%m/%Y'),'$fname','$sname','$lname','$idCountry')";
    $result = $conn->query($sql);
    if (!$result) {
		echo 'Could not run query: ' . mysql_error();
		exit;
    }
	
}

// Función que encapsula la tarea de capturar una imagen del navegador y copiarla al servidor.
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
	<title>Coaches</title>
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
          <!-- Menú de navegación por la página -->
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
        <button  type="button" class="btn btn-block btn-info btn-lg" data-target="#addStadiumForm" data-toggle="collapse"<?php echo $hidden; ?>>Add a new coach
          <i class="fa fa-fw fa-lg fa-plus-circle"></i>
        </button>
        <br>
          <!-- Espacio para agregar datos para insertar un nuevo entrenador -->
        <div id="addStadiumForm" class="collapse"<?php echo $hidden; ?>>
          <div class="row">
            <div class="col-md-12">
              <form role="form" class="form-horizontal" action="coaches.php" method="POST" enctype="multipart/form-data">
                <div class="col-md-4">
                  <img src="img/defaultProfile.jpg" class="center-block img-responsive">
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <div class="col-sm-4">
                      <label class="control-label">Name</label>
                    </div>
                    <div class="col-sm-8">
                      <input name="fnameCoach" type="text" class="form-control" placeholder="John">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-4">
                      <label class="control-label">Second name</label>
                    </div>
                    <div class="col-sm-8">
                      <input name="snameCoach" type="text" class="form-control" placeholder="Albert">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-4">
                      <label class="control-label">Last name</label>
                    </div>
                    <div class="col-sm-8">
                      <input name="lnameCoach" type="text" class="form-control" placeholder="Doe">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-4">
                      <label class="control-label">Picture</label>
                    </div>
                    <div class="col-sm-8">
                      <input type="file" name="picture">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-4">
                      <button name="addCoach" type="submit" class="btn btn-success">Add Coach</button>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <div class="col-sm-4">
                      <label class="control-label">Id number</label>
                    </div>
                    <div class="col-sm-8">
                      <input name="dniCoach" type="text" class="form-control" placeholder="123457890">
                    </div>
                  </div>
                   <div class="form-group">
                    <div class="col-sm-4">
                      <label class="control-label">Country</label>
                    </div>
                    <div class="col-sm-8">
                      <select name="idCountry" class="selectpicker" data-width="100%" data-live-search="true">
                         <?php 
                          // Código para rellenar el select con los paísese que existan en la base
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
                      <label class="control-label">Birthdate</label>
                    </div>
                    <div class="col-sm-8" id="dateSelector">
                      <!--<input type="text" class="form-control" placeholder="dd/mm/yyyy" id="datepicker">-->
                      <div class="input-group date">
                        <input name="birthdate" type="text" class="form-control">
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
				 
                /*
                    Este código se encarga de rellenar la página con todos los entrenadores y sus respectivos datos.
                    El siguiente código recupera la información necesaria
                */
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
						
				    // Se genera un "objeto" para organizar los datos
					echo "<div class=\"col-md-3\">";
                    echo "<a href=\"#\" data-toggle=\"popover\" data-title=\"$nameCoach\" class=\"popper\"><img src=\"uploads/people/players/pic$dniCoach\" class=\"center-block img-responsive\"></a>";
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
        // Manejo de los selectores de fecha y cuadros desplegables
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