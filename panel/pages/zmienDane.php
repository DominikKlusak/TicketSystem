<?php
session_start();
require('../classes/Database.class.php');

$db = new Database();
$conn = $db->connect();

if (!empty($_POST['nimie']) && !empty($_POST['nnazwisko']) && !empty($_POST['nmiasto']) && !empty($_POST['nkraj']) && !empty($_POST['nulica'])) {


    $imie = strip_tags(htmlentities($_POST['nimie']));
    $nazwisko = strip_tags(htmlentities($_POST['nnazwisko']));


    $miasto = strip_tags(htmlentities($_POST['nmiasto']));
    $kraj = strip_tags(htmlentities($_POST['nkraj']));
    $ulica = strip_tags(htmlentities($_POST['nulica']));



    if (strlen($imie) < 30 && strlen($nazwisko) < 30) {




        if (preg_match('/^[a-zA-Z0-9ąćęńśłóźżĄĆĘŃŚÓŁŹŻ\+\&\;\-\.\,\/ ]+$/', $miasto)) {
            if (preg_match('/^[a-zA-Z0-9ąćęńśłóźżĄĆĘŃŚÓŁŹŻ\+\&\;\-\.\,\/ ]+$/', $kraj)) {
                if (preg_match('/^[a-zA-Z0-9ąćęńśłóźżĄĆĘŃŚÓŁŹŻ\+\&\;\-\.\,\/ ]+$/', $ulica)) {

                    $uid = $_SESSION['id'];


                    $sql3 = "UPDATE users SET 
                        imie = '" . mysqli_real_escape_string($conn, $imie) . "',
                        nazwisko = '" . mysqli_real_escape_string($conn, $nazwisko) . "',
                        miasto = '" . mysqli_real_escape_string($conn, $miasto) . "',
                        kraj = '" . mysqli_real_escape_string($conn, $kraj) . "',
                        ulica = '" . mysqli_real_escape_string($conn, $ulica) . "' where id = '" . $uid . "'";

                        $db->doQuery($sql3);

                        $_SESSION['newDaneSuccess'] = true;
                    
                }
            } else {
                $_SESSION['newDaneError'] = "Niepoprawne znaki w polu miasto";
            }
        } else {
            $_SESSION['newDaneError'] = "Niepoprawne znaki w polu miasto";
        }
    } else {
        $_SESSION['newDaneError'] = "Zbyt dużo znaków w polu imię lub nazwisko";
    }
} else {
    $_SESSION['newDaneError'] = "Wypełnij wszystkie wymagane pola.";
}

header('Location: main.php');

?>