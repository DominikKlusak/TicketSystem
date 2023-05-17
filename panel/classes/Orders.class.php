<?php

class Orders
{

    public function getAllOrders($conn)
    {

        $sql = "select * from zamowienia_klientow";

        if ($zapytanie = $conn->query($sql)) {

            $num = $zapytanie->num_rows;

            $arr = [];

            if ($num > 0) {


                while ($orders = $zapytanie->fetch_assoc()) {

                    $arr[] = $orders;
                }
            }
        }

        return $arr;
    }

    public function getOrderStatus($conn, $id)
    {

        $sql = "select status from zamowienia_klientow where id = '" . mysqli_real_escape_string($conn, $id) . "' LIMIT 1";
        $status = null;


        if ($zapytanie = $conn->query($sql)) {

            $tmp = $zapytanie->fetch_assoc();

            $status = $tmp['status'];
        }

        return $status;
    }

    public function getOrderById($conn, $id)
    {

        $sql = "select * from zamowienia_klientow where id = '" . mysqli_real_escape_string($conn, $id) . "' LIMIT 1";
        $order = array();


        if ($zapytanie = $conn->query($sql)) {

            $tmp = $zapytanie->fetch_assoc();

            $order[] = $tmp;
        }

        return $order;
    }

    public function getUserOrders($conn, $id, $limit)
    {

        $sql = "select * from zamowienia_klientow where user_login = '" . mysqli_real_escape_string($conn, $id) . "' LIMIT " . $limit . "";
        $orders = array();


        if ($zapytanie = $conn->query($sql)) {

            $num = $zapytanie->num_rows;


            if ($num > 0) {

                $tmp = $zapytanie->fetch_assoc();

                $orders[] = $tmp;
            }
        }

        return $orders;
    }

    public function getOrderLabel($status)
    {

        $label = "";

        if ($status != "") {
            if ($status == "złożone") {
                $label = '<button type="button" class="btn btn-block bg-gradient-secondary btn-sm"> Złożone </button>';
            } else if ($status == "wysłane") {
                $label = '<button type="button" class="btn btn-block bg-gradient-primary btn-sm"> Wysłane </button>';
            } else if ($status == "anulowane") {
                $label = '<button type="button" class="btn btn-block bg-gradient-danger btn-sm"> Anulowane </button>';
            } else if ($status == "zrealizowane") {
                $label = '<button type="button" class="btn btn-block bg-gradient-success btn-sm"> Zrealizowane </button>';
            } else {
                $label =  '<button type="button" class="btn btn-block bg-gradient-warning btn-sm"> Błąd! </button>';
            }
        }

        return $label;
    }
}
