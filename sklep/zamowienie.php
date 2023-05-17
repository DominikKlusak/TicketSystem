<?php
session_start();
require('../panel/classes/Database.class.php');
$token = session_id();

$database = new Database();


// sprawdzam czy w koszyku są jakieś produkty

$sql = "select * from koszyk where aktywny = 'on' and sesja = '" . $token . "'";

$ileProduktow = $database->doSelect($sql, true);

if ($ileProduktow > 0) {
?>


    <!DOCTYPE html>
    <html lang="pl">

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Strona Główna sklepu</title>
        <!-- BOOSTRAP -->
        <link href="css/bootstrap.css" rel="stylesheet" />
        <link href="css/style.css" rel="stylesheet" />
        <link href="css/koszyk.css" rel="stylesheet" />

    <body>
        <?php
        $tab = 3;
        require('navigacja.php');
        include('header.php');
        ?>

        <section class="py-9">

            <div class="container px-4 py-4 mx-auto" style="min-height: 500px;">


                <div class="row">
                    <aside class="col-lg-9">
                        <div class="cardd">

                            <div class="row justify-content-center">

                                <div class="wrapper" style="color: #000;">
                                    <div class="row">

                                        <div class="contact-wrap w-100 p-md-5 p-4">
                                            <span class="mb-3 text-center" style="font-size: 25px;"> Twoje dane w celu realizacji zamówienia. </span>
                                            <br><br>
                                            <div class="alert alert-primary" role="alert">
                                                <i class="fa fa-info-circle" style="font-size: 25px; padding-right: 10px;"></i>
                                                Jeżeli posiadasz u nas konto wprowadź przypisany do niego adres e-mail. <br>
                                                <strong> Szczegóły zamówienia będa tam widoczne </strong>
                                            </div>

                                            <?php
                                            if (isset($_SESSION['zamowienieError'])) {

                                                echo ' <div class="alert alert-danger" role="alert">
                                                            <i class="fa fa-exclamation-triangle" style="font-size: 25px; padding-right: 10px;"></i>
                                                             ' . $_SESSION['zamowienieError'] . '
                                                        </div>';
                                                unset($_SESSION['zamowienieError']);
                                            } else if (isset($_SESSION['zamowienieSuccess'])) {

                                                echo ' <div class="alert alert-success" role="alert">
                                                            <i class="fa fa-check" style="font-size: 25px; padding-right: 10px;"></i>
                                                            ' . $_SESSION['zamowienieSuccess'] . '
                                                        </div>';

                                                         // Trzeba wyczyścić koszyk.
                                                $sql2 = "update koszyk set aktywny = 'off' where sesja = '".mysqli_real_escape_string($conn, $token)."'";
                                                $database->doQuery($sql2);
                                                
                                                unset($_SESSION['zamowienieSuccess']);
                                            }
                                            ?>

                                            <br>
                                            <form method="POST" action="formularze/zamowienieController.php">
                                                <div class="row">
                                                    <label> Podstawowe dane: </label>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" name="zimie" placeholder="Imię">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" name="znazwisko" placeholder="Nazwisko">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <input type="email" class="form-control" name="zemail" placeholder="Email">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <label> Adres wysyłki: </label>
                                                    <div class="col-md-4 mt-3">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" name="zkraj" placeholder="Kraj">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mt-3">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" name="zmiasto" placeholder="Miasto">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mt-3">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" name="zulica" placeholder="Ulica">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <label> Sposób dostarczenia: </label>
                                                    <div class="col-md-4 mt-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input" value="tak" type="radio" name="zkurierDPD" id="zkurierDPD">
                                                            <label class="form-check-label">
                                                                <strong> Kurier DPD - +16 ZŁ PLN </strong>
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" value="tak" type="radio" name="zkurierINPOST" id="zkurierINPOST">
                                                            <label class="form-check-label">
                                                                <strong> Kurier INPOST - +10 ZŁ PLN </strong>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mt-4">
                                                    <label> Dodatkowe informacje: </label>
                                                    <div class="col-md-12 mt-3">
                                                        <div class="form-group">
                                                            <textarea name="zuwagi" class="form-control" cols="5" rows="2" placeholder="Uwagi"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 mt-4">
                                                        <div class="form-group d-flex justify-content-end">

                                                            <button type="submit" class="btn btn-primary">
                                                                <i class="fa fa-check"></i> Potwierdzam zamówienie
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>

                                        </div>

                                    </div>
                                </div>

                            </div>

                        </div>
                    </aside>
                    <aside class="col-lg-3 ">

                        <div class="card ">
                            <div class="card-body">
                                <strong> Podsumowanie zamówienia </strong> <br><br>
                                <?php
                                $podsumowanie = $produkty->getCartItems($conn, $token);

                                for ($p = 0; $p < count($podsumowanie); $p++) {
                                    $lp = $p + 1;
                                    echo $lp . " - " . $podsumowanie[$p]['nazwa'] . " - " . $podsumowanie[$p]['cena'] . " PLN <br>";
                                }
                                ?>
                                <strong> + Koszt dostawy KURIER </strong> <br><br><br>

                                <img style="width: 100%;" src="zdjecia/tpay.jpg" alt="Płatności Tpay">
                            </div>
                        </div>
                    </aside>
                </div>
            </div>

        </section>

        <?php
        include('stopka.php');
        ?>

    </body>

    </html>



<?php
} else {

    $_SESSION['koszykInfo'] = "Aby złożyć zamówienie musisz wybrać coś ze sklepu.";
    header('Location: koszyk.php');
}



?>