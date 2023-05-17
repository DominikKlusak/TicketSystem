<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pl">
<body>
    <?php
    $tab = 1;
    include('navigacja.php');
    include('header.php');
    ?>



    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">


            <?php

            $pro = new Produkty();

            $lista = $pro->getProductList($conn);

            $ile = count($lista);

            if ($ile > 0) {
                echo '<div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">';
                for ($v = 0; $v < $ile; $v++) {


                    echo '<div class="col mb-5">';
                    echo '<div class="card h-100">

                                 <img class="card-img-top d-flex mt-auto" src="' . $lista[$v]['zdjecie'] . '" alt="' . $lista[$v]['nazwa'] . '" />

                                    <div class="card-body p-4">
                                        <div class="text-center">

                                            <h5 class="fw-bolder">' . $lista[$v]['nazwa'] . '</h5>
                                            ' . $lista[$v]['cena'] . ' PLN
                                        </div>
                                    </div>

                                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                        <div class="text-center">
                                        <a class="btn btn-outline-dark mt-auto" onclick="koszyk(' . $lista[$v]['id'] . ', 2)"><i class="fa fa-cart-plus"></i> Dodaj do koszyka</a></div>
                                    </div>
                             </div>';
                    echo '</div>';
                }
                echo '</div>';
            }

            ?>
        </div>


        <!-- Button -->
        <button type="button" id="buttonModalShow" style="display: none;" class="btn btn-primary" data-toggle="modal" data-target="#addProductInfo">
             Pokaż modal
        </button>

        <!-- Modal -->
        <div class="modal fade" id="addProductInfo" tabindex="-1" role="dialog" aria-labelledby="addProductInfo" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addProductInfo">Produkt dodany!</h5>
                    </div>
                    <div class="modal-body" style="padding: 10px;">
                        <p class="text-center">

                             <strong> Produkt został dodany do koszyka! </strong> <br><br>
                            <i class="fas fa-check" style="color: green; font-size: 45px;"></i>

                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="location.reload(true);">Zamknij</button>
                    </div>
                </div>
            </div>
        </div>




    </section>

    <?php
    include('stopka.php');
    ?>

</body>

</html>