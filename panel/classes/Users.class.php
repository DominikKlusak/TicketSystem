<?php


class Users {

    public function isAdmin($conn, $id) {

        $admin = false;

        $sql = "select administrator from users where id = '".mysqli_real_escape_string($conn, $id)."'";

        if ($z = $conn->query($sql)) {

            $i = $z -> num_rows;

            if ($i > 0) 
            {

                $r = $z -> fetch_assoc();

                if ($r['administrator'] == 'tak') {
                    $admin = true;
                }

            }

        }

        return $admin;


    }

    public function getUserPhoto($conn, $id) {

        $photo = '';

        $sql = "select zdjecie from users where id = '".mysqli_real_escape_string($conn, $id)."'";

        if ($z = $conn->query($sql)) {

            $i = $z -> num_rows;

            if ($i > 0) 
            {

                $r = $z -> fetch_assoc();

                $photo = $r['zdjecie'];

            }

        }

        return $photo;

    }

    public function getAdminList($conn) {

        $admins = array();

        $sql = "select id, imie, nazwisko, zdjecie, state, administrator from users where administrator = 'tak' and state ='on'";

        if ($z = $conn->query($sql)) {

            $i = $z -> num_rows;

            if ($i > 0) 
            {

                $r = $z -> fetch_assoc();

                $admins[] = $r;

            }

        }

        return $admins;

    }

    public function getUserDetailsByid($conn, $id) {

        $user = array();

        $sql = "select * from users where id = '".mysqli_real_escape_string($conn, $id)."'";

        if ($z = $conn->query($sql)) {

            $i = $z -> num_rows;

            if ($i > 0) 
            {

                $r = $z -> fetch_assoc();
                $user[] = $r;

            }

        }

        return $user;

    }

    public function getAllUsers($conn) {

        $sql = "select * from users where state = 'on'";

        $tablica = array();

        if ($z = $conn->query($sql))
        {
            

            if ($z->num_rows > 0) {

                while ($user = $z->fetch_assoc()) {

                    $tablica[] = $user;

                }

            }

        }

        return $tablica;

    }


}



?>