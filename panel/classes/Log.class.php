<?php

    class Log {

        public function addHistoryLog($conn, $user, $zamowienie, $text) {

            $sql = "INSERT INTO `historia_zamowien`(`id`, `user_id`, `zam_id`, `czynnosc`, `data_czynnosci`, `status`) 
            VALUES 
            ('',
            '".$user."',
            '".$zamowienie."',
            '".$text."',
            now(),
            'on')";

            if ($conn->query($sql)) {
                return true;
            }
            
        }

        public function getHistoryLog($conn, $zamowienie, $uid) {

            $arr = array();

                if ($zapytanie = $conn->query("select u.imie, u.zdjecie, h.czynnosc, h.data_czynnosci from historia_zamowien h left join users u on u.id = h.user_id where h.zam_id ='" . mysqli_real_escape_string($conn, $zamowienie) . "' AND h.status = 'on' AND h.user_id = '".$uid."'")) 
                {

                    $liczbaHistorii = $zapytanie->num_rows;

                        if ($liczbaHistorii > 0) {

                            while ($row = $zapytanie->fetch_assoc()) {

                                $arr[] = $row;
                            }
                        }
                    
                }


            return $arr;


        }

    }


?>