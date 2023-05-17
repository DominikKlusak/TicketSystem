<?php


class Produkty
{


    public function getProductList($conn)
    {

        $arr = array();

        if ($zapytanie = $conn->query("select * from produkty where status = 'on' order by id desc")) {

            $liczbaProduktow = $zapytanie->num_rows;

            if ($liczbaProduktow > 0) {

                while ($row = $zapytanie->fetch_assoc()) {

                    $arr[] = $row;
                }
            }
        }

        return $arr;
    }


    public function getCartItems($conn, $sesja, $count = false)
    {

        $arr = array();

        if ($zapytanie = $conn->query("select k.sesja, k.produkt_id, k.aktywny, k.id, p.nazwa, p.cena, p.status, p.zdjecie from koszyk k left join produkty p on k.produkt_id = p.id where k.sesja = '" . mysqli_real_escape_string($conn, $sesja) . "' AND k.aktywny = 'on' order by k.id desc")) {

            $liczbaProduktow = $zapytanie->num_rows;

            if ($count == false) {

                if ($liczbaProduktow > 0) {

                    while ($row = $zapytanie->fetch_assoc()) {

                        $arr[] = $row;
                    }
                }
            } else {
                $arr = $liczbaProduktow;
            }
        }





        return $arr;
    }

    public function getProductDetailsById($conn, $id)
    {

        $arr = array();

        if ($zapytanie = $conn->query("select * from produkty where id ='" . mysqli_real_escape_string($conn, $id) . "' AND status = 'on'")) 
        {

            $liczbaProduktow = $zapytanie->num_rows;

                if ($liczbaProduktow > 0) {

                    while ($row = $zapytanie->fetch_assoc()) {

                        $arr[] = $row;
                    }
                }
            
        }


        return $arr;
    }

    

}
