<?php

session_start();
spl_autoload_register(function ($class) {
  include 'classes/' . $class . '.class.php';
});

$_SESSION['uploadInfo'] = "";
$uploadInfo = $_SESSION['uploadInfo'];

$target_dir = "img/";
$name = explode(".", $_FILES["fileToUpload"]["name"]);

$nazwa = $name[0].$_SESSION['id'];
$target_name = basename($nazwa.".".$name[1]);


$target_file = $target_dir . $target_name;

$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
		
		
		
		if (($check[2] !== IMAGETYPE_GIF) && ($check[2] !== IMAGETYPE_JPEG) && ($check[2] !== IMAGETYPE_PNG)) {
			$_SESSION['uploadInfo'] = "<div class=\"alert alert-danger\"><i class=\"fas fa-exclamation-circle\"></i> Dozwolone są tylko rozszerzenia JPG, JPEG, PNG i GIF</div>";
			 $uploadOk = 0;
		}
		
		
    } else {
      $_SESSION['uploadInfo'] = "<div class=\"alert alert-danger\"><i class=\"fas fa-exclamation-circle\"></i> Plik nie jest obrazem.</div>";
        $uploadOk = 0;
    }
}
if (file_exists($target_file)) {
    if (unlink($target_file))
	{
		$uploadOk = 1;
	} else {
		$uploadOk = 0;
	}
} 

$type= $_FILES["fileToUpload"]["type"]; 
$extensions= array('image/jpg','image/jpeg','image/png','image/gif');
    if(!in_array($type, $extensions)){
        $_SESSION['uploadInfo'] = "<div class=\"alert alert-danger\"><i class=\"fas fa-exclamation-circle\"></i> Dozwolone są tylko rozszerzenia JPG, JPEG, PNG i GIF</div>";
		$uploadOk = 0;
    }

// Rozmiar pliku
if ($_FILES["fileToUpload"]["size"] > 128000) {
    echo $_SESSION['uploadInfo'] = "<div class=\"alert alert-danger\"><i class=\"fas fa-exclamation-circle\"></i> Maksymalny rozmiar pliku to 100 KB.</div>";
    $uploadOk = 0;
}

if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
      $_SESSION['uploadInfo'] = "<div class=\"alert alert-danger\"><i class=\"fas fa-exclamation-circle\"></i> Dozwolone są tylko rozszerzenia JPG, JPEG, PNG i GIF</div>";
    $uploadOk = 0;
}

if ($uploadOk == 0) {
   echo $uploadInfo = "Przepraszamy Twój plik nie został przesłany.";

} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
		$id = $_SESSION['id'];

    $db = new Database();
    $polaczenie = $db->connect();

		$update_logo_sql = "update users set zdjecie = 'img/".mysqli_real_escape_string($polaczenie,$target_name)."' where id = '".mysqli_real_escape_string($polaczenie, $id)."'";
		
		if ($zapytanie = @$polaczenie->query($update_logo_sql))
		{
			 $_SESSION['uploadInfo'] = "<div class=\"alert alert-success\"><i class=\"fas fa-check-circle\"></i> Plik ". basename( $_FILES["fileToUpload"]["name"]). " został pomyślnie przesłany.</div>";
			
		}
    } else {
        $_SESSION['uploadInfo'] =  "<div class=\"alert alert-danger\"><i class=\"fas fa-exclamation-circle\"></i> Przepraszamy, wystąpił nieznany błąd podczas przesłania pliku. </div>";
    }
}

	header('Location: pages/main.php');
?>