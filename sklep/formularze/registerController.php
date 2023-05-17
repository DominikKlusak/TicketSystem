<?php
session_start();
    require('../../panel/classes/Database.class.php');

    if (!empty($_POST['rimie']) && !empty($_POST['rnazwisko']) && !empty($_POST['rhaslo']) && !empty($_POST['remail']) && !empty($_POST['rmiasto']) && !empty($_POST['rkraj']) && !empty($_POST['rulica'])){


        $imie = strip_tags(htmlentities($_POST['rimie']));
        $nazwisko = strip_tags(htmlentities($_POST['rnazwisko']));
        $email = filter_var($_POST['remail'], FILTER_SANITIZE_EMAIL);
        $haslo = strip_tags(htmlentities($_POST['rhaslo']));

        $miasto = strip_tags(htmlentities($_POST['rmiasto']));
        $kraj = strip_tags(htmlentities($_POST['rkraj']));
        $ulica = strip_tags(htmlentities($_POST['rulica']));

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

            if (strlen($imie) < 30 && strlen($nazwisko) < 30) {


                $validHaslo = false;
                $znaki = preg_match("/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{8,40}$/", $haslo);		
                if($znaki /* Znak specjalny, duza liter, liczba, powyzej 8 znaków!*/) {
                    $validHaslo = true;
                } 

                if ($validHaslo) {

                    $haslo = md5($haslo);

                    if (preg_match('/^[a-zA-Z0-9ąćęńśłóźżĄĆĘŃŚÓŁŹŻ\+\&\;\-\.\,\/ ]+$/', $miasto)) {
                        if (preg_match('/^[a-zA-Z0-9ąćęńśłóźżĄĆĘŃŚÓŁŹŻ\+\&\;\-\.\,\/ ]+$/', $kraj)) {
                            if (preg_match('/^[a-zA-Z0-9ąćęńśłóźżĄĆĘŃŚÓŁŹŻ\+\&\;\-\.\,\/ ]+$/', $ulica)) {

                                // validacja przebiegła pomyślnie - dodajemy rekord do bazy
                                $db = new Database();
                                $conn = $db->connect();

                                    // sprawdzam czy istnieje już taki adres email w bazie
                                $duplikatEmail = "select `login` from `users` where `login` = '".mysqli_real_escape_string($conn, $email)."'";

                                $czyIstnieje = $db->doSelect($duplikatEmail, true);
                                if ($czyIstnieje > 0) 
                                {
                                    $_SESSION['registerError'] = "Taki e-mail już istnieje w naszej bazie.";
                                } 
                                else {

                                    $sql = "INSERT INTO `users`(`id`, `login`, `haslo`, `imie`, `nazwisko`, `zdjecie`, `miasto`, `kraj`, `ulica`, `administrator`, `state`)
                                        VALUES 
                                        ('',
                                        '".mysqli_real_escape_string($conn, $email)."',
                                        '".mysqli_real_escape_string($conn, $haslo)."'
                                        ,'".mysqli_real_escape_string($conn, $imie)."'
                                        ,'".mysqli_real_escape_string($conn, $nazwisko)."'
                                        ,'img/default.png'
                                        ,'".mysqli_real_escape_string($conn, $miasto)."'
                                        ,'".mysqli_real_escape_string($conn, $kraj)."',
                                        '".mysqli_real_escape_string($conn, $ulica)."',
                                        'nie',
                                        'on')";

                                        if ($conn->query($sql)) {
                                            $_SESSION['registerSuccess'] = true;
                                        } 
                                        else { $_SESSION['registerError'] = "Błąd zapytania"; }

                                }
                            
                                
                                
                                


                            }
                        } else { $_SESSION['registerError'] = "Niepoprawne znaki w polu miasto"; }

                    } else { $_SESSION['registerError'] = "Niepoprawne znaki w polu miasto"; }



                } else { $_SESSION['registerError'] = "Hasło powinno mięc przynajmniej 8 znaków, dużą literę, cyfrę i znak specjalny"; }



            }  else { $_SESSION['registerError'] = "Zbyt dużo znaków w polu imię lub nazwisko"; }



        } else { $_SESSION['registerError'] = "Wprowadzono niepoprawny adres e-mail!"; }

    } else { $_SESSION['registerError'] = "Wypełnij wszystkie wymagane pola."; }

    header('Location: ../rejestracja.php');

?>