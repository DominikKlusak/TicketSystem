<?php

use tpayLibs\examples\BankSelectionExample;

session_start();
$token = session_id();

spl_autoload_register(function ($class) {
    include '../../panel/classes/' . $class . '.class.php';
});

    if ((!empty($_POST['zimie'])) && (!empty($_POST['znazwisko'])) && (!empty($_POST['zemail'])) )
    {
        if ((!empty($_POST['zkraj'])) && (!empty($_POST['zmiasto'])) && (!empty($_POST['zulica'])))
        {
            if ((!empty($_POST['zkurierDPD'])) || (!empty($_POST['zkurierINPOST']))) {

                $imie = strip_tags(htmlentities($_POST['zimie']));
                $nazwisko = strip_tags(htmlentities($_POST['znazwisko']));
                $email = strip_tags(htmlentities($_POST['zemail']));

                $kraj = strip_tags(htmlentities($_POST['zkraj']));
                $miasto = strip_tags(htmlentities($_POST['zmiasto']));
                $ulica = strip_tags(htmlentities($_POST['zulica']));

                $kurierDPD = (isset($_POST['zkurierDPD'])) ? "tak" : "nie";
                $kurierINPOST = (isset($_POST['zkurierINPOST'])) ? "tak" : "nie";

                $uwagi = (isset($_POST['zuwagi'])) ? strip_tags(htmlentities($_POST['zuwagi'])) : ""; // pole nie wymagane

                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

                    if (strlen($imie) < 30 && strlen($nazwisko) < 30) {

                        $dane = array(
                            'imie' => $imie,
                            'nazwisko' => $nazwisko,
                            'kraj' => $kraj,
                            'miasto' => $miasto,
                            'ulica' => $ulica
                        );

                        $errors = 0;

                        foreach ($dane as $dana => $value) {

                            if (!preg_match('/^[a-zA-Z0-9ąćęńśłóźżĄĆĘŃŚÓŁŹŻ\+\&\;\-\.\,\/ ]+$/', $value)) {
                                $_SESSION['zamowienieError'] .= "Niepoprawne znaki w polu ".$dana."<br>";
                                $errors++;
                            }
                        }

                        if (isset($_POST['zuwagi']) && $_POST['zuwagi'] != "") {
                            if (!preg_match('/^[a-zA-Z0-9ąćęńśłóźżĄĆĘŃŚÓŁŹŻ\+\&\;\-\.\,\/ ]+$/', $_POST['zuwagi'])) {
                                $_SESSION['zamowienieError'] .= "Niepoprawne znaki w polu UWAGI";
                            }
                        }

                        // brak błędów.
                        if ($errors == 0) {


                                $database = new Database();
                                $pro = new Produkty();
                                $conn = $database->connect();
                            
                                $lista_produktow = array();

                                $Ile_w_koszyku = $pro -> getCartItems($conn, $token, true);
                                $koszyk = $pro -> getCartItems($conn, $token);

                                if ($Ile_w_koszyku > 0) {

                                    $cena = 0;

                                    for ($y = 0; $y < $Ile_w_koszyku; $y++) {
                                        $lista_produktow[] = $koszyk[$y]['produkt_id'];
                                        $cena += $koszyk[$y]['cena'];
                                    }

                    
                                    $produkty_new = implode("-", $lista_produktow);
                    
                                    $sql = "INSERT INTO `zamowienia_klientow`(`id`, `user_login`, `data_zam`, `produkt_id`, `sesja_id`, `imie`, `nazwisko`, `kraj`, `miasto`, `ulica`, `kurierDPD`, `kurierINPOST`, `uwagi`, `status`) 
                                        VALUES 
                                        ('',
                                        '".$email."',
                                        now(),
                                        '".$produkty_new."',
                                        '".$token."',
                                        '".$imie."',
                                        '".$nazwisko."',
                                        '".$kraj."',
                                        '".$miasto."',
                                        '".$ulica."',
                                        '".$kurierDPD."',
                                        '".$kurierINPOST."',
                                        '".$uwagi."',
                                        'złożone')";
                    
                                        if ($conn->query($sql)) {

                                            $_SESSION['bankImie'] = $imie;
                                            $_SESSION['bankCena'] = $cena;
                                           
                                            header('Location: ../platnosci.php');
                                            $_SESSION['zamowienieSuccess'] .= " Twoje zamówienie zostało zarejestrowane pod numerem <strong> #".$database->getLastIdOfColumn('zamowienia_klientow')." </strong> <br> Oczekuj teraz na informację z naszej strony!";
                                            exit(0);
                                        } else {
                                            $_SESSION['zamowienieError'] .= "Błąd w wykonaniu zapytania";
                                        }

                                        


                                 } 
                                 else {
                                    $_SESSION['zamowienieError'] .= "W koszyku nie znaleziono produktów.";
                                 }
                        }

                    } else {  $_SESSION['zamowienieError'] = "Pole imie lub nazwisko jest zbyt długie."; }

                } else {  $_SESSION['zamowienieError'] = "Podano niepoprawny adres e-mail"; }

            }
            else {
                $_SESSION['zamowienieError'] = "Musisz wybrać sposób dostawy.";
            }

        }
        else {
            $_SESSION['zamowienieError'] = "Pole kraj, miasto, ulica są wymagane!";
        }


    } else {
        $_SESSION['zamowienieError'] = "Wypełnij wszystkie wymagane pola!";
    }

    
    header('Location: ../zamowienie.php');
?>