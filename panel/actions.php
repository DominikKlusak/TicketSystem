<?php
session_start();
spl_autoload_register(function ($class) {
    include 'classes/' . $class . '.class.php';
});

include('functions.php');

$db = new Database();
$users = new Users();
$conn = $db->connect();

$isAdmin = $users->isAdmin($conn, $_SESSION['id']);

$o = "";

if (isset($_POST['action'])) {

    if ($_POST['action'] == "changePassword") {

        if (isset($_POST['oldPass']) && isset($_POST['newPass1']) && isset($_POST['newPass2']) && isset($_POST['user_id'])) {

            $user_id = $_POST['user_id'];
            $oldPass = $_POST['oldPass'];
            $newPass1 = $_POST['newPass1'];
            $newPass2 = $_POST['newPass2'];

            $oldPass = md5($_POST['oldPass']);
            $sessionId = $_SESSION['id'];


            // sprawdzam czy stare haslo jest poprawne
            $sql = "select haslo from users where id = '" . $sessionId . "' and haslo = '" . mysqli_real_escape_string($conn, $oldPass) . "'";

            $ile = $db->doSelect($sql, true);

            // stare haslo jest poprawne
            if ($ile > 0) {

                // teraz czy nowe hasla są identyczne
                if (md5($newPass1) == md5($newPass2)) {


                    $znaki = preg_match("/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{8,40}$/", $newPass1);
                    if ($znaki /* Znak specjalny, duza liter, liczba, powyzej 8 znaków!*/) {

                        $newPass1 = md5($newPass1);

                        // jest ok to robię update.
                        $sql2 = "update users set haslo = '" . $newPass1 . "' where id = '" . $sessionId . "'";
                        $db->doQuery($sql2);
                        $o = 1;
                    } else {
                        $o = "Hasło musi skladać się z min. 8 znaków, dużej litery i znaku specjalnego.";
                    }
                } else {
                    $o = "Nowe hasła nie są takie same.";
                }
            } else {
                $o = "Stare hasło jest niepoprawne.";
            }
        } else {
            $o = "Brak danych.";
        }
    } elseif ($_POST['action'] == "WyslijMaila") {

        if ($isAdmin) {

            if (isset($_POST['email']) && isset($_POST['wiadomosc']) && isset($_POST['id'])) {

                $log = new Log();

                //sendMail($temat, $tresc, $email)
                $temat = "Informacja!";
                $email = $_POST['email'];
                $tresc = $_POST['wiadomosc'];
                $id = $_POST['id'];

                if (sendMail($temat, $tresc, $email)) {
                    $o = 1;
                } else {
                    $o = "Błąd";
                }

                $log = new Log();

                $log->addHistoryLog($conn, $_SESSION['id'], $id, "Wysłano maila z powiadomieniem.");
            }
        }
    } elseif ($_POST['action'] == "WyslijOdpMail") {

        if ($isAdmin) {

            if (isset($_POST['email']) && isset($_POST['wiadomosc'])) {

                $log = new Log();

                //sendMail($temat, $tresc, $email)
                $temat = "Odpowiedź!";
                $email = $_POST['email'];
                $tresc = $_POST['wiadomosc'];

                if (sendMail($temat, $tresc, $email)) {
                    $o = 1;
                } else {
                    $o = "Błąd";
                }

                $log = new Log();
            }
        }
    } elseif ($_POST['action'] == "saveZam") {

        if ($isAdmin) {

            $id = $_POST['id'];
            $imie = $_POST['imie'];
            $nazwisko = $_POST['nazwisko'];
            $ulica = $_POST['ulica'];
            $miasto = $_POST['miasto'];
            $kraj = $_POST['kraj'];
            $uwagi = $_POST['uwagi'];
            $kurier = $_POST['kurier'];

            $kurierDPD = ($kurier == "KurierDPD") ? "tak" : "nie";
            $kurierINPOST = ($kurier == "KurierINPOST") ? "tak" : "nie";

            $sql = "UPDATE `zamowienia_klientow` SET 
                `imie`='" . $imie . "',
                `nazwisko`='" . $nazwisko . "',
                `kraj`='" . $kraj . "',
                `miasto`='" . $miasto . "',
                `ulica`='" . $ulica . "',
                `kurierDPD`='" . $kurierDPD . "',
                `kurierINPOST`='" . $kurierINPOST . "',
                `uwagi`='" . $uwagi . "' WHERE id = '" . $id . "'";

            $conn->query($sql);
            $o = 1;

            $log = new Log();

            $log->addHistoryLog($conn, $_SESSION['id'], $id, "Zmieniono dane zamówienia.");
        }
    } elseif ($_POST['action'] == "addNewUser") {

        if ($isAdmin) {

            $imie = $_POST['imie'];
            $nazwisko = $_POST['nazwisko'];
            $ulica = $_POST['ulica'];
            $miasto = $_POST['miasto'];
            $kraj = $_POST['kraj'];
            $login = $_POST['login'];
            $haslo = $_POST['haslo'];
            $admin = $_POST['admin'];

            if (filter_var($login, FILTER_VALIDATE_EMAIL)) {

                if (strlen($imie) < 30 && strlen($nazwisko) < 30) {


                    $validHaslo = false;
                    $znaki = preg_match("/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{8,40}$/", $haslo);
                    if ($znaki /* Znak specjalny, duza liter, liczba, powyzej 8 znaków!*/) {
                        $validHaslo = true;
                    }

                    if ($validHaslo) {

                        $haslo = md5($haslo);

                        // validacja przebiegła pomyślnie - dodajemy rekord do bazy
                        $db = new Database();
                        $conn = $db->connect();

                        // sprawdzam czy istnieje już taki adres email w bazie
                        $duplikatEmail = "select `login` from `users` where `login` = '" . mysqli_real_escape_string($conn, $login) . "'";

                        $czyIstnieje = $db->doSelect($duplikatEmail, true);
                        if ($czyIstnieje > 0) {
                            $o = "Taki e-mail/login już istnieje w naszej bazie.";
                        } else {

                            $sql = "INSERT INTO `users`(`id`, `login`, `haslo`, `imie`, `nazwisko`, `zdjecie`, `miasto`, `kraj`, 
                                        `ulica`, `administrator`, `state`)
                                                VALUES 
                                                ('',
                                                '" . mysqli_real_escape_string($conn, $login) . "',
                                                '" . mysqli_real_escape_string($conn, $haslo) . "'
                                                ,'" . mysqli_real_escape_string($conn, $imie) . "'
                                                ,'" . mysqli_real_escape_string($conn, $nazwisko) . "'
                                                ,'img/default.png'
                                                ,'" . mysqli_real_escape_string($conn, $miasto) . "'
                                                ,'" . mysqli_real_escape_string($conn, $kraj) . "',
                                                '" . mysqli_real_escape_string($conn, $ulica) . "',
                                                '" . $admin . "',
                                                'on')";

                            if ($conn->query($sql)) {
                                $o = 1;
                            } else {
                                $o = "Błąd zapytania";
                            }
                        }
                    } else {
                        $o = "Hasło powinno mięc przynajmniej 8 znaków, dużą literę, cyfrę i znak specjalny";
                    }
                } else {
                    $o = "Zbyt dużo znaków w polu imię lub nazwisko";
                }
            } else {
                $o = "Wprowadzono niepoprawny adres e-mail /login !";
            }
        }
    } 
    
    elseif ($_POST['action'] == "editNewUser") {

        if ($isAdmin) {


            $id = $_POST['id'];
            $imie = $_POST['imie'];
            $nazwisko = $_POST['nazwisko'];
            $ulica = $_POST['ulica'];
            $miasto = $_POST['miasto'];
            $kraj = $_POST['kraj'];
            $login = $_POST['login'];
            $haslo = $_POST['haslo'];
            $admin = $_POST['admin'];

            if (filter_var($login, FILTER_VALIDATE_EMAIL)) {

                if (strlen($imie) < 30 && strlen($nazwisko) < 30) {

                        $haslo = md5($haslo);

                        // validacja przebiegła pomyślnie - dodajemy rekord do bazy
                        $db = new Database();
                        $conn = $db->connect();


                            $sql = "UPDATE `users` SET `login` = '" . mysqli_real_escape_string($conn, $login) . "',
                                                `haslo` = '" . mysqli_real_escape_string($conn, $haslo) . "',
                                                `imie` = '" . mysqli_real_escape_string($conn, $imie) . "',
                                                `nazwisko` = '" . mysqli_real_escape_string($conn, $nazwisko) . "',
                                                `miasto` = '" . mysqli_real_escape_string($conn, $miasto) . "',
                                                `kraj` = '" . mysqli_real_escape_string($conn, $kraj) . "',
                                                `ulica` = '" . mysqli_real_escape_string($conn, $ulica) . "',
                                                `administrator` = '" . $admin . "' WHERE id = '".$id."'";

                            if ($conn->query($sql)) {
                                $o = 1;
                            } else {
                                $o = "Błąd zapytania";
                            }
                        
                   
                } else {
                    $o = "Zbyt dużo znaków w polu imię lub nazwisko";
                }
            } else {
                $o = "Wprowadzono niepoprawny adres e-mail /login !";
            }
        }
    } 
    
    elseif ($_POST['action'] == "ZmienStatus") {

        if ($isAdmin) {

            $id = $_POST['id'];
            $status = $_POST['status'];


            $sql = "UPDATE `zamowienia_klientow` SET `status`='" . $status . "' WHERE id = '" . $id . "'";

            $conn->query($sql);
            $o = 1;

            $log = new Log();

            $log->addHistoryLog($conn, $_SESSION['id'], $id, "Zmieniono status zamówienia na: " . $status . " .");
        }
    } 
    elseif ($_POST['action'] == "delUser") {

        if ($isAdmin) {

            $id = $_POST['id'];

            $sql = "UPDATE `users` SET `state`='off' WHERE id = '" . $id . "'";

            $conn->query($sql);
            $o = 1;
        }
    }
    else if ($_POST['action'] == "sendAdminMessage") {

        if ($isAdmin) {

            if (isset($_POST['message']) && !empty($_POST['sesja'])) {

                $mess = strip_tags(htmlentities($_POST['message']));
                $sesja = $_POST['sesja'];
                $sid = (isset($_SESSION['id'])) ? $_SESSION['id'] : 0;

                $sql = "select * from kontakt where kanal = 'CHAT' and sesja_id = '" . $sesja . "'";

                $czyjest = $db->doSelect($sql, true);



                if ($czyjest > 0) {



                    $sql1 = "INSERT INTO `chat_wiadomosci`(`id`, `przeczytane`, `sesja_id`, `data_add`, `kto_dodal`, `wiadomosc`) 
                        VALUES ('', 'nie', '" . $sesja . "', now(),'" . $sid . "','" . $mess . "')";

                    if ($conn->query($sql1)) {

                        $data_add = date('Y-m-d H:i:s');
                        $classUser = new Users();

                        $uuser = $classUser->getUserDetailsByid($conn, $sid);
                        $imie = $uuser[0]['imie'];

                        $us = $classUser->getUserPhoto($conn, $sid);

                        $zdjecie = (isset($us)) ? $us : "img/default.png";

                        $o = ' <li class="left clearfix">
                                <span class="chat-img1 pull-left">
                                    <img src="../' . $zdjecie . '" alt="Avatar" class="img-circle">
                                    ' . $imie . '
                                </span>
                                <div class="chat-body1 clearfix">
                                    <p>' . $mess . '</p>
                                    <div class="chat_time pull-right">' . $data_add . '</div>
                                </div>
                            </li>';
                    }
                } else {
                    $o = 0;
                }
            } else {
                $o = 'err';
            }
        }
    } elseif ($_POST['action'] == "przydzielPracownika") {

        if ($isAdmin) {

            $id = $_POST['id'];
            $opiekun = $_POST['opiekun'];

            $log = new Log();

            $log->addHistoryLog($conn, $_SESSION['id'], $id, "Przydzielono opiekuna: " . $opiekun . " .");

            $o = 1;
        }
    } elseif ($_POST['action'] == "prepareeditNewUser") {

        if ($isAdmin) {

            $id = $_POST['id'];

            // sprawdzam czy istnieje już taki adres email w bazie
            $sql = "select `id` from `users` where `id` = '" . mysqli_real_escape_string($conn, $id) . "'";

            $czyIstnieje = $db->doSelect($sql, true);

            if ($czyIstnieje > 0) {

                $classUser = new Users();

                $user = $classUser->getUserDetailsByid($conn, $id);

                $imie = $user[0]['imie'];
                $nazwisko = $user[0]['nazwisko'];

                $id = $user[0]['id'];
                $login = $user[0]['login'];
                $haslo = $user[0]['haslo'];
                $miasto = $user[0]['miasto'];
                $kraj = $user[0]['kraj'];
                $ulica = $user[0]['ulica'];
                $admin = $user[0]['administrator'];

                $o = ' <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Imię:</label>
                        <input type="text" id="e-imie" class="form-control" value="' . $imie . '" placeholder="Imię">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nazwisko:</label>
                        <input type="text" id="e-nazwisko" class="form-control" value="' . $nazwisko . '" placeholder="Nazwisko">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Login:</label>
                        <input type="text" id="e-login" class="form-control" value="' . $login . '" placeholder="Login (email)">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Hasło</label>
                        <input type="password" id="e-haslo" class="form-control" value="' . $haslo . '" placeholder="Hasło">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Administrator:</label>
                        <select id="e-admin" class="form-control">
                            <option value="' . $admin . '">' . $admin . '</option>
                            <option value="nie">NIE</option>
                            <option value="tak">TAK</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Miasto:</label>
                        <input id="e-miasto" type="text" class="form-control" value="' . $miasto . '" placeholder="Miasto">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Kraj:</label>
                        <input type="text" id="e-kraj" class="form-control" value="' . $kraj . '" placeholder="Kraj">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Ulica:</label>
                        <input type="text" id="e-ulica" class="form-control" value="' . $ulica . '" placeholder="Ulica">
                    </div>
                </div></div></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
                    <button type="button" onclick="editNewUser('.$id.')" class="btn btn-success">Edytuj</button>
                ';
            } else {
                $o = 'err';
            }
        }
    }
}

echo $o;
