<?php
session_start();
require('../classes/Database.class.php');

if ( (!empty($_POST['email'])) && (!empty($_POST['haslo'])) ) {

    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $haslo = md5(htmlspecialchars(strip_tags($_POST['haslo'])));

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $db = new Database();
        $conn = $db->connect();

        $query = sprintf("SELECT * FROM users WHERE login='%s' AND haslo='%s'",
                mysqli_real_escape_string($conn, $email),
                mysqli_real_escape_string($conn, $haslo)
        );

        $ile = $db->doSelect($query, true);
       
        if ( $ile == 1 ) {

            // znaleziono takiego użytkownika
            $user = $db->doSelect($query);

            $_SESSION['id'] = $user[0]['id'];
            $_SESSION['login'] = $user[0]['login'];
            $_SESSION['haslo'] = $user[0]['haslo'];
            $_SESSION['imie'] = $user[0]['imie'];
            $_SESSION['nazwisko'] = $user[0]['nazwisko'];
            $_SESSION['zdjecie'] = $user[0]['zdjecie'];
            $_SESSION['miasto'] = $user[0]['miasto'];
            $_SESSION['kraj'] = $user[0]['kraj'];
            $_SESSION['ulica'] = $user[0]['ulica'];
            $_SESSION['administrator'] = $user[0]['administrator'];
            $_SESSION['state'] = $user[0]['state'];

            $_SESSION['zalogowany'] = true;


            header('Location: ../pages/main.php');
            exit(0);
        
        } else {
            header('Location: ../index.php');
            $_SESSION['loginError'] = '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Niepoprawne dane!';
        }


    } else {
        header('Location: ../index.php');
        $_SESSION['loginError'] = '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Niepoprawny adres e-mail';
    }



} else {
    header('Location: ../index.php');
    $_SESSION['loginError'] = '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Wprowadź dane';
}

    

?>