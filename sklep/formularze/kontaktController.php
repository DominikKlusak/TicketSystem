<?php
session_start();
require('../../panel/classes/Database.class.php');

        /* cimie, cemail, ctemat, cwiadomosc */

        if (!empty($_POST['cimie']) && !empty($_POST['cemail']) && !empty($_POST['ctemat']) && !empty($_POST['cwiadomosc'])){


            $imie = strip_tags(htmlentities($_POST['cimie']));
            $temat = strip_tags(htmlentities($_POST['ctemat']));
            $wiadomosc = strip_tags(htmlentities($_POST['cwiadomosc']));
            $email = filter_var($_POST['cemail'], FILTER_SANITIZE_EMAIL);

            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

                if (strlen($imie) < 30 && strlen($temat) < 30) {

                    if (preg_match('/^[a-zA-Z0-9ąćęńśłóźżĄĆĘŃŚÓŁŹŻ\?\+\&\;\-\.\,\/ ]+$/', $wiadomosc)) {

                        $db = new Database();
                        $conn = $db->connect();

                        $sql = "INSERT INTO `kontakt`(`id`, `kanal`,`imie`, `email`, `temat`, `wiadomosc`, `kiedy_wyslano`, `status`) 
                        VALUES (
                            '',
                            'FORMULARZ',
                            '".mysqli_real_escape_string($conn, $imie)."',
                            '".mysqli_real_escape_string($conn, $email)."',
                            '".mysqli_real_escape_string($conn, $temat)."',
                            '".mysqli_real_escape_string($conn, $wiadomosc)."',
                            now(),
                            'on')";

                        if ($conn->query($sql)) {
                            $_SESSION['kontaktSuccess'] = true;
                        } else
                        {
                            $_SESSION['kontaktError'] = "Błąd zapytania.";
                        }
                        

                    } else {
                        $_SESSION['kontaktError'] = "Wprowadzono niedozwolone znaki w polu wiadomość.";
                    }

                        

                } else {
                    $_SESSION['kontaktError'] = "Zbyt wiele znaków w polu imię lub temat.";
                }

            } else {
                $_SESSION['kontaktError'] = "Wprowadzono niepoprawny adres e-mail.";
            }



        } else { $_SESSION['kontaktError'] = "Uzupełnij wszystkie pola aby wysłać wiadomość."; }

    header('Location: ../kontakt.php');

?>