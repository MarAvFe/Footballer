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

// Fragmento para manejar y validar el registro de un nuevo estadio y la actualización de su imagen.
if(isset($_POST["addStadium"])){
	echo "agregar estadio";
	$nameStadium = $_POST["nameStadium"];
	$capacity = $_POST["capacity"];
	$city = $_POST["city"];
    uploadPicture($_FILES["picture"], $capacity.$city, 0);
	echo $nameStadium;
	echo $capacity;
	echo $city;
	$sql = "call insertStadium('$nameStadium','$capacity','$city')";
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
	<title>Stadium</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="http://pingendo.github.io/pingendo-bootstrap/themes/default/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="./css/bootstrap-select.min.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="./js/bootstrap-select.min.js"></script>
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
        <div class="row">
          <div class="col-md-12">
            <div class="well">
              <h1 class="text-center">Stadiums</h1>
            </div>
          </div>
        </div>
        <button type="button" class="btn btn-block btn-info btn-lg" data-target="#addStadiumForm" data-toggle="collapse"<?php echo $hidden; ?>>Add a new stadium
          <i class="fa fa-fw fa-lg fa-plus-circle"></i>
        </button>
        <br>
          <!-- Formulario que recibe todos los datos sobre un nuevo estadio a crear -->
        <div id="addStadiumForm" class="collapse"<?php echo $hidden; ?>>
          <div class="row">
            <div class="col-md-12">
              <form class="form-horizontal" role="form" action="stadiums.php" method="POST" enctype="multipart/form-data">
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
                    <input type="file" name="picture">
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
                  <div class="col-sm-offset-3 col-sm-1">
                    <label class="control-label">City</label>
                  </div>
                  <div class="col-sm-8">
                    <select name="city" class="selectpicker" data-live-search="true" data-width="100%">
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
              
          <!-- Para mostrar cada estadio y su información y fotografía -->
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
                                    list($peeps, $country) = split(' ', $capacity);
									echo"<img alt=\"estadio\" src=\"uploads/stadiums/pic$peeps"."1\" height=\"120\">";
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