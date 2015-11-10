<?php
session_start();
$idPerson = $_POST['idPerson'];

$_SESSION['loggedIn'] = $_SESSION['idPerson'] > 0;
if(!$_SESSION['loggedIn']){
    //header("Location: ./index.php");
}

$uploadOk = 1;
// Check if image file is a actual image or fake image
if(isset($_POST["submitProfilePic"])) {
    uploadPicture($_FILES["fileToUpload"], 0);
}


if(isset($_POST["submitVariedPictures"])) {
    for($i=1; $i < 6; $i++){
        $picture = "pic".$i;
        if(!$_FILES[$picture]['tmp_name']==""){
            uploadPicture($_FILES[$picture], $i);
        }
    }
}

function uploadPicture($picture, $numPic){
    $target_dir = "uploads/picsOf".$_SESSION['idPerson']."/";
    $target_file = $target_dir . basename($picture['name']);
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
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
        if (move_uploaded_file($picture["tmp_name"], $target_dir."pic".$numPic)) {
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="es">
<head>
    <meta charset="utf-8" />
    <title>Wow page - Much page</title>
    
    <!-- 960 gs -->
    <link rel="stylesheet" type="text/css" media="all" href="css/reset.css" />
    <link rel="stylesheet" type="text/css" media="all" href="css/text.css" />
    <link rel="stylesheet" type="text/css" media="all" href="css/960.css" />
    
     <!-- Formalize -->
    <link rel="stylesheet" type="text/css" media="all" href="css/formalize.css" />
    <script src="js/jquery.formalize.js"></script>
    
    <!-- Apycom -->
    <link rel="stylesheet" type="text/css" media="all" href="css/menu.css" />
    <script src="js/menu.js"></script>
    
    <!-- Angular -->
    <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js"></script>
    
    <!-- Dropzone -->
    <script src="js/dropzone.js"></script>
    <link rel="stylesheet" href="css/dropzone.css">
    <script type="text/javascript">
        Dropzone.options.myAwesomeDropzone = {
            paramName: "file", // The name that will be used to transfer the file
            maxFilesize: 2, // MB
        };
    </script>
    <!-- Nuestro css -->
    <link rel="stylesheet" type="text/css" media="all" href="css/estilos.css" />
    <script type="text/javascript" src="js/jquery.js"></script>
</head>
    
<body>
    <main class="container_16">

        <nav class="grid_12 prefix_4">
            <div id="menu">
                <ul class="menu">
				<li><a href="./myProfile.php"><span>My profile</span></a></li>
                <li><a href="./search.php"><span>Search</span></a></li>
				<li><a href="./match.php"><span>Match</span></a></li>
				<li><a href="./tops.php"><span>Tops</span></a>
                <li><a href="./createEvent.php"><span>Events</span></a>
                    <div><ul>
                    <li><a href="./createEvent.php"><span>Create New Event</span></a></li>
                    <li><a href="./events.php"><span>View Events</span></a></li>
                    </ul></div>
                    </li>
                <li><a href="./history.php"><span>History</span></a></li>
                
                <li><a href="#" class="parent"><span>Options</span></a>
                    <div><ul>
                    <li><a href="#"><span>Edit profile</span></a></li>
                    <li><a href="./parameters.php"><span>Change Parameters</span></a></li>
                    <li><a href="./registerValues.php"><span>Change Register Values</span></a> </li>
                    <li><a href="./termsAndConditions.html"><span>Terms and Conditions</span></a></li>
                    <li><a href="./index.php"><span>Sign out</span></a></li>
                    </ul></div>
                    </li>
                </ul>
            </div> 
        </nav>
        
        <div class="clear spacer"></div>
        <div class="editablePartTemplate">
            
            
            
            
            
        
            <section class="grid_10 prefix_3 suffix_3 uploadPictures" ng-app="logInApp">
                <h1>Upload pictures</h1>
                <form action="images.php" method="post" enctype="multipart/form-data">
                    <h6>Select profile picture to upload:</h6>
                    <img width="250" height="250" alt="pic2" src="uploads/picsOf<?php echo $idPerson;?>/pic0">
                    <input type="file" name="fileToUpload" id="fileToUpload">
                    <input hidden="hidden" value="<?php echo $idPerson; ?>" name="idPerson">
                    <input type="submit" value="Upload Image" name="submitProfilePic">
                </form>
                <div class="clear spacer"></div>
                
                <h3>Varied pictures</h3>
                <form  action="images.php" method="post" enctype="multipart/form-data">
                    <table>
                        <tr>
                            <th><h6>Pic #</h6></th>
                            <th><h6>Preview uploaded</h6></th>
                            <th><h6>Upload route...</h6></th>
                        </tr>
                        <tr>
                            <td><h6>#1</h6></td>
                            <td>
                                <img width="150" height="150" alt="pic1" src="uploads/picsOf<?php echo $idPerson;?>/pic1">
                            </td>
                            <td>
                                <input type="file" name="pic1" id="fileToUpload">
                            </td>
                        </tr>
                        <tr>
                            <td><h6>#2</h6></td>
                            <td>
                                <img width="150" height="150" alt="pic2" src="uploads/picsOf<?php echo $idPerson;?>/pic2">
                            </td>
                            <td>
                                <input type="file" name="pic2" id="fileToUpload">
                            </td>
                        </tr>
                        <tr>
                            <td><h6>#3</h6></td>
                            <td>
                                <img width="150" height="150" alt="pic3" src="uploads/picsOf<?php echo $idPerson;?>/pic3">
                            </td>
                            <td>
                                <input type="file" name="pic3" id="fileToUpload">
                            </td>
                        </tr>
                        <tr>
                            <td><h6>#4</h6></td>
                            <td>
                                <img width="150" height="150" alt="pic4" src="uploads/picsOf<?php echo $idPerson;?>/pic4">
                            </td>
                            <td>
                                <input type="file" name="pic4" id="fileToUpload">
                            </td>
                        </tr>
                        <tr>
                            <td><h6>#5</h6></td>
                            <td>
                                <img width="150" height="150" alt="pic5" src="uploads/picsOf<?php echo $idPerson;?>/pic5">
                            </td>
                            <td>
                                <input type="file" name="pic5" id="fileToUpload">
                            </td>
                        </tr>
                    </table>
                    <input hidden="hidden" value="<?php echo $idPerson; ?>" name="idPerson">
                    <input type="submit" value="Upload all pictures" name="submitVariedPictures">
                </form>
                                    
            </section>
            
            
            
            
            
            
            
        </div>
        <hr>
        <div class="grid_14 prefix_2">
            <div class="grid_4">
                <a href="./fullRegister.html">Full Register Page</a> <br>
                <a href="./createEvent.html">Create event</a> <br>
                <a href="#">Online users: <span>32</span></a> <br></div>
            <div class="grid_4">
                <a href="#">Help</a> <br>
                <a href="#">Don't talk to us</a> <br>
                <a href="./topWinks.html">Top winks</a> <br>
            </div>
            <div class="grid_4">
                <a href="#">Terms and Conditions</a> <br>
            </div>
        </div>
        <hr>
        <div class="spacer clear"></div>
        <div class="grid_3 prefix_13" style="background-color:#666">Match Me - ©2015</div>
        
    </main>
</body>

<!-- <a href="http://apycom.com/">jQuery Menu by Apycom</a> -->
</html>