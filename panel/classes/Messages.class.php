<?php

    class Messages {

        public function UpdateEmails($conn) {
            
            if (!function_exists('imap_open')) {
                return "Trzeba włączyć rozszerzenie w folderze php/php.ini ;extension imap.";
            } else {

                if ($connection = imap_open('{poczta.interia.pl:993/imap/ssl}INBOX', 'mojnowysklep1@interia.pl', 'Pracamagisterska!!!!')) {

                    $mails = imap_search($connection, 'Unseen'); //Unseen - nieprzeczytane // All - wszystkie.

                    if (!empty($mails)) {

                        $ileMaili = count($mails);
                
                        if ($ileMaili > 0) {
                
                            for ($x = 0; $x < $ileMaili; $x++) {
                
                                $headers = imap_headerinfo($connection, $mails[$x]);
                
                                $m_temat = quoted_printable_decode($headers->Subject);
                                $m_nazwa = quoted_printable_decode($headers->fromaddress);
                                $m_data = date('Y-m-d H:i:s', $headers->udate);
                                $m_od = $headers->from;
                
                                foreach ($m_od as $id => $obiekt) {
                                    $m_odkogo = $obiekt->mailbox . "@" . $obiekt->host;
                                }
                
                                $znaki = array('?', '=', 'utf-8', 'Q', 'UTF-8','iso-8859');
                
                                $m_temat = str_replace($znaki, '', $m_temat);
                                $m_nazwa = str_replace($znaki, '', $m_nazwa);

                                $sql = "select id from kontakt where email = '".mysqli_real_escape_string($conn, $m_odkogo)."' 
                                AND temat = '".$m_temat."' AND kiedy_wyslano = '".$m_data."'";

                                if ($zapytanie = $conn->query($sql)) {

                                    $czyJestJuz = $zapytanie->num_rows;

                                    if ($czyJestJuz < 1) {

                                        $sql2 = "INSERT INTO `kontakt`(`id`, `kanal`, `email`, `temat`, `kiedy_wyslano`, `status`) 
                                        VALUES (
                                            '',
                                            'EMAIL',
                                            '".$m_odkogo."',
                                            '".$m_temat."',
                                            '".$m_data."',
                                            'on')";

                                        $conn->query($sql2);


                                    }


                                }
                
                
                               
                            }
                        }
                    }


                } else {
                    return "Problem z połączeniem skrzynki pocztowej.";
                }



            }


        }


        public function getAllEmails($conn) {

            $sql = "select id, kanal, email, temat, wiadomosc, kiedy_wyslano, status from kontakt where status = 'on'";

            $tablica = array();

            if ($z = $conn->query($sql))
            {
                

                if ($z->num_rows > 0) {

                    while ($email = $z->fetch_assoc()) {

                        $tablica[] = $email;

                    }

                }

            }

            return $tablica;

        }

        public function getWiadomoscById($conn, $id) {

            $sql = "select id, sesja_id, kanal, email, imie, temat, wiadomosc, kiedy_wyslano, status from kontakt where id = '".$id."' AND status = 'on'";

            $tablica = array();

            if ($z = $conn->query($sql))
            {
                

                if ($z->num_rows > 0) {

                    while ($wiadomosc = $z->fetch_assoc()) {

                        $tablica[] = $wiadomosc;

                    }

                }

            }

            return $tablica;

        }

        public function getMessegesBySession($conn, $sesja) {

            $sql = "select cw.data_add, cw.kto_dodal, cw.sesja_id, cw.wiadomosc, u.imie, u.zdjecie from chat_wiadomosci cw left join users u on cw.kto_dodal = u.id where cw.sesja_id = '".$sesja."'";

            $tablica = array();

            if ($z = $conn->query($sql))
            {
                

                if ($z->num_rows > 0) {

                    while ($wiadomosc = $z->fetch_assoc()) {

                        $tablica[] = $wiadomosc;

                    }

                }

            }

            return $tablica;

        }

    }

?>