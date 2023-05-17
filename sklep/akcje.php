<?php
session_start();
spl_autoload_register(function ($class) {
    include '../panel/classes/' . $class . '.class.php';
});

$db = new Database();
$conn = $db->connect();

$odp = "";

if (isset($_POST['action'])) {

    if ($_POST['action'] == "koszyk") {

        if (isset($_POST['produkt_id']) && isset($_POST['sesja']) && isset($_POST['todo'])) {

            $produkt_id = filter_var($_POST['produkt_id'], FILTER_SANITIZE_NUMBER_INT);
            $todo = filter_var($_POST['todo'], FILTER_SANITIZE_NUMBER_INT); // 2 - dodanie, 1 - usunięcie
            $sesja = strip_tags(htmlentities($_POST['sesja']));

            $sql = "select * from koszyk 
                    where produkt_id = '" . mysqli_real_escape_string($conn, $produkt_id) . "' 
                    AND sesja = '" . mysqli_real_escape_string($conn, $sesja) . "' and aktywny = 'on'";

            $result = $conn->query($sql);
            $czy_w_koszyku = $result->num_rows;


            if ($todo == 2) {
                // DODANIE DO KOSZYKA

                if ($czy_w_koszyku < 1) {

                    $sql = "INSERT INTO `koszyk` (`id`, `produkt_id`, `sesja`, `aktywny`) VALUES 
                                ('',
                                '" . mysqli_real_escape_string($conn, $produkt_id) . "',
                                '" . mysqli_real_escape_string($conn, $sesja) . "',
                                'on')";

                    if ($conn->query($sql)) {
                        $odp = 1;
                    } else {
                        $odp = "Błąd zapytania";
                    }
                } else {
                    $odp = "Taki produkt już jest w koszyku.";
                }
            } else if ($todo == 1) {
                // USUNIĘCIE Z KOSZYKA

                if ($czy_w_koszyku > 0) {

                    $sql = "DELETE FROM `koszyk` where produkt_id = '" . mysqli_real_escape_string($conn, $produkt_id) . "' 
                                AND sesja = '" . mysqli_real_escape_string($conn, $sesja) . "'";

                    if ($conn->query($sql)) {
                        $odp = 1;
                    } else {
                        $odp = "Błąd zapytania";
                    }
                } else {

                    $odp = "Takiego produkty nie masz w koszyku. (?)";
                }
            }
        }
    } else if ($_POST['action'] == "sendMessage") {

        if (isset($_POST['message']) && !empty($_POST['message'])) {

            $mess = strip_tags(htmlentities($_POST['message']));
            $sid = (isset($_SESSION['id'])) ? $_SESSION['id'] : 0;

            $sql = "select * from kontakt where kanal = 'CHAT' and sesja_id = '" . session_id() . "'";

            $czyjest = $db->doSelect($sql, true);

            if ($czyjest < 1) {

                $sql2 = "INSERT INTO `kontakt`(`id`, `kanal`, `sesja_id`, `imie`, `email`, `temat`, `wiadomosc`, 
                        `kiedy_wyslano`, `status`) VALUES 
                        ('',
                        'CHAT',
                        '" . session_id() . "',
                        '" . session_id() . "',
                        '" . session_id() . "',
                        '" . $mess . "',
                        '" . $mess . "',
                        now(),
                        'on')";

                $db->doQuery($sql2);
            }

            $sql1 = "INSERT INTO `chat_wiadomosci`(`id`, `przeczytane`, `sesja_id`, `data_add`, `kto_dodal`, `wiadomosc`) 
                    VALUES ('', 'tak', '" . session_id() . "', now(),'" . $sid . "','" . $mess . "')";

             if ($conn->query($sql1)) {

                $data_add = date('Y-m-d H:i:s');
                $classUser = new Users();

                $us = $classUser->getUserPhoto($conn, $sid);

                $zdjecie = "../panel/img/default.png";

                    $odp = ' <div class="direct-chat-msg">
                    <div class="direct-chat-infos clearfix">
                        <span class="direct-chat-name float-left"> Ja </span>
                        <span class="direct-chat-timestamp float-right">' . $data_add . '</span>
                    </div>
                    <img class="direct-chat-img" src="'.$zdjecie.'" alt="Avatar3">
                    <div class="direct-chat-text">' . $mess . '
                    </div>
                </div>';


            } else {
                $odp = 0;
            }
        } else {
            $odp = 'err';
        }
    } 
    else if ($_POST['action'] == "getChatMessenges") {

        if (isset($_POST['sesja']) && !empty($_POST['sesja'])) {

            $sesja = $_POST['sesja'];

            $sql = "select * from chat_wiadomosci where sesja_id = '" . $sesja . "' and przeczytane = 'nie' LIMIT 1";

            $czyjest = $db->doSelect($sql, true);

            if ($czyjest > 0) {

                $classUser = new Users();

                    $mes = $db->doSelect($sql);


                   // $odp = print_r($mes);

                        $user = $classUser->getUserDetailsByid($conn, $mes[0]['kto_dodal']);

                        $mesId = $mes[0]['id'];

                        $imie = (isset($user[0]['imie'])) ? $user[0]['imie'] : "Ja";
                        $zdjecie = (isset($user[0]['zdjecie'])) ? $user[0]['zdjecie'] : "img/default.png";
                        $data = $mes[0]['data_add'];
                        $wiadomosc = $mes[0]['wiadomosc'];

                        $odp = ' <div class="direct-chat-msg">
                                <div class="direct-chat-infos clearfix">
                                    <span class="direct-chat-name float-left">'.$imie.'</span>
                                    <span class="direct-chat-timestamp float-right">' . $data . '</span>
                                </div>
                                <img class="direct-chat-img" src="../panel/'.$zdjecie.'" alt="Avatar3">
                                <div class="direct-chat-text">' . $wiadomosc . '
                                </div>
                        </div>';

                        $sql2 = "update chat_wiadomosci set przeczytane = 'tak' where id = '".$mesId."'";
                        $db->doQuery($sql2);
                    
            } else {
                $odp = 'err';
            }
        } else {
            $odp = 'err';
        }
    }

   



}



echo $odp;
