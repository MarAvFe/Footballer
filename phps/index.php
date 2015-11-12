<?php
session_start();

// Recibe los datos que utilizará todo el sitio para manejar las conexiones a la base de datos
$_SESSION['server'] = 'soccer2.clupi7ohqydz.us-west-2.rds.amazonaws.com';
$_SESSION['username'] = 'mainSoccer';
$_SESSION['password'] = '123';
$_SESSION['dbname'] = 'mydb';

// Crea una nueva conexión
$conn = new mysqli($_SESSION['server'], $_SESSION['username'], $_SESSION['password'], $_SESSION['dbname']);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Valida el inicio de sesión del administrador
$loginFail = 0;
if(isset($_POST['user'])){
    $sql = "select mydb.isLogin('".$_POST['user']."', '".md5($_POST['pass'])."');";
    $result = $conn->query($sql);
    $row = $result->fetch_row();
    if($row[0] == 1){
        $newURL = 'adminPage.php';
        $_SESSION['loggedUser'] = $_POST['user'];
        header('Location: '.$newURL);
        die();
    }else{
        $loginFail = 1;
    }
}


$hasError = $loginFail>0 ? ' has-error' : '';

?>
<!DOCTYPE html5><html>
<head> 
	<title>Home</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="css/home.css" rel="stylesheet" type="text/css">
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
          <form class="navbar-form navbar-left" role="search" action="index.php" method="post">
            <div class="form-group<?php echo $hasError; ?>">
              <input class="form-control" id="exampleInputEmail1" placeholder="Enter user" type="text" name="user">
              <input class="form-control" id="exampleInputPassword1" placeholder="Password" type="password" name="pass">
            </div>
            <button type="submit" class="btn btn-primary">Sign In
              <i class="-o fa fa-fw fa-lg fa-sign-in text-inverse"></i>
            </button>
          </form>
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
              <!-- Datos, imágenes y subtítulos de las noticias de la primera plana -->
            <div id="fullcarousel-example" data-interval="false" class="carousel slide" data-ride="carousel">
              <div class="carousel-inner">
                <div class="active item">
                  <img src="img/backgroundSoccerField.jpg">
                  <div class="carousel-caption">
                    <h1>Last game</h1>
                    <p class="lead">Psg falls by 4 against Uruguay FC in Clubs World Cup. Costa Rica is making
                      history</p>
                  </div>
                </div>
                <div class="item">
                  <img src="img/partido2.jpg">
                  <div class="carousel-caption">
                    <h1>Hard to get</h1>
                    <p class="lead">In Brazil's match they couldn't get the ball from the opposition.</p>
                  </div>
                </div>
                <div class="item">
                  <img src="img/partido3.jpg">
                  <div class="carousel-caption">
                    <h1>Faster rival</h1>
                    <p class="lead">Mexico crushes South Africa 5-2 after Southafrican's DT fight</p>
                  </div>
                </div>
              </div>
                <!-- Botones de control del carrusel -->
              <a class="left carousel-control" href="#fullcarousel-example" data-slide="prev"><i class="icon-prev fa fa-angle-left"></i></a>
              <a class="right carousel-control" href="#fullcarousel-example" data-slide="next"><i class="icon-next fa fa-angle-right"></i> </a>
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
                <a href="#"><i class="fa fa-3x -o fa-fw text-inverse fa-ge"></i></a>
                <a href="#"><i class="fa fa-3x fa-fw text-inverse fa-group"></i></a>
                <a href="#"><i class="fa fa-3x fa-fw text-inverse fa-futbol-o"></i></a>
                <a href="#"><i class="fa fa-3x fa-fw hub text-inverse fa-rebel"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </footer>
<?php $conn->close(); ?>
</body></html>