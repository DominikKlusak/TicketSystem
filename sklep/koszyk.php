<?php
session_start();
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
    include('navigacja.php');
    include('header.php');
    ?>

    <section class="py-9">

        <div class="container px-4 py-4 mx-auto" style="min-height: 500px;">


            <div class="row">
                <aside class="col-lg-9">
                    <div class="cardd">

                        <?php
                        if (isset($_SESSION['koszykInfo'])) :
                        ?>
                            <div class="alert alert-primary" role="alert">
                                <?php echo $_SESSION['koszykInfo']; ?>
                            </div>
                        <?php
                            unset($_SESSION['koszykInfo']);
                        endif;
                        ?>

                        <div class="table-responsive">
                            <table class="table table-borderless table-shopping-cart">
                                <thead class="text-muted">
                                    <tr class="small text-uppercase">
                                        <th scope="col">Produkt</th>
                                        <th scope="col">Nazwa</th>
                                        <th scope="col" width="120">Cena</th>
                                        <th scope="col" class="text-right d-none d-md-block" width="200"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $koszyk = new Produkty();

                                    $koszyk_lista = $koszyk->getCartItems($conn, $token);


                                    if (is_array($koszyk_lista)) {
                                        if (count($koszyk_lista) > 0) {

                                            $cena = 0.00;

                                            for ($x = 0; $x < count($koszyk_lista); $x++) {

                                                echo '
                                                                    <tr style="border-bottom: 1px solid #e4e4e4;">
                                                                        <td>
                                                                            <figure class="itemside align-items-center">
                                                                                <div class="aside"><img src="' . $koszyk_lista[$x]['zdjecie'] . '" class="img-lg"></div>
                                                                            </figure>
                                                                        </td>
                                                                        <td>
                                                                            <figcaption class="info"> <span class="title text-dark" data-abc="true">' . $koszyk_lista[$x]['nazwa'] . '</span></figcaption>
                                                                        </td>
                                                                      
                                                                        <td>
                                                                            <div class="price-wrap"> <var class="price">' . $koszyk_lista[$x]['cena'] . ' PLN </var> </div>
                                                                        </td>
                                                                        <td class="text-right d-none d-md-block"> <button class="btn btn-danger" onclick="koszyk(' . $koszyk_lista[$x]['produkt_id'] . ', 1)" data-abc="true"> <i class="fa fa-trash"></i> Usuń </button> </td>
                                                                    </tr>';

                                               

                                                $cena += $koszyk_lista[$x]['cena'];
                                            }
                                        } else {
                                            echo '
                                                            <tr>
                                                                <td colspan="3"> <strong> Twój koszyk jest aktualnie pusty. </strong> </td>
                                                            </tr>
                                                            ';
                                        }
                                    }
                                    ?>


                                </tbody>
                            </table>
                        </div>
                    </div>
                </aside>
                <aside class="col-lg-3">

                    <div class="card">

                        <div class="card-body">
                            <dl class="dlist-align">
                                <dt>Cena: </dt>
                                <dd class="" style="padding-right: 5px;"> <span style='margin-left: 5px;'> <?php if (isset($cena)) {
                                                                                                                echo $cena;
                                                                                                            } else {
                                                                                                                echo "0.00";
                                                                                                            }
                                                                                                            echo " PLN"; ?> </span></dd>
                            </dl>
                            <dl class="dlist-align">
                                <dt>Żniżka: </dt>
                                <dd class="text-right text-danger ml-3"> <span style='margin-left: 5px;'> 0.00 PLN </span> </dd>
                            </dl>
                            <dl class="dlist-align">
                                <dt>Razem łącznie: </dt>
                                <dd class="text-right text-dark b ml-3"> <span style='margin-left: 5px;'> <?php echo "<strong> ";
                                                                                                            if (isset($cena)) {
                                                                                                                echo $cena;
                                                                                                            } else {
                                                                                                                echo "0.00";
                                                                                                            }
                                                                                                            echo " PLN </strong>"; ?> </span> </dd>
                            </dl>
                            <hr> <a href="zamowienie.php" class="btn btn-out btn-primary btn-square btn-main" data-abc="true"> Zamawiam! </a>
                            <a href="index.php" class="btn btn-out btn-success btn-square btn-main mt-2" data-abc="true"> Wróć do sklepu</a>
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