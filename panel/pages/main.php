<?php
include('../header.php');

if (!isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] !== true) {
    header('Location: ../index.php');
    exit(0);
}

$user = new Users();
$db = new Database();
$conn = $db->connect();

$userDet = $user->getUserDetailsByid($conn, $_SESSION['id']);



?>


<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-3 border-right">

            <div class="d-flex justify-content-between align-items-center mb-3">
                            <a class="btn btn-primary" href="../../sklep"><i class="fa fa-arrow-left"></i> Powrót do sklepu </a>
                        </div>

                <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                    <img class="rounded-circle mt-5" width="150px" src="<?php echo '../' . $user->getUserPhoto($conn, $_SESSION['id']); ?>">

                    <span class="font-weight-bold"><?php echo $userDet[0]['imie']; ?></span><span class="text-black-50">Pozycja:
                        <?php echo $pozycja = ($user->isAdmin($conn, $_SESSION['id'])) ? "Administrator" : "Klient"; ?></span>

                    <span class="mt-3">
                        <button class="btn btn-primary d-flex justify-content-center" data-toggle="modal" data-target="#ModalResetPassword">
                            <i class="fa fa-lock"></i> Zmień hasło
                        </button>
                    </span>

                    <div style="width: 100%;" class="mt-5">

                        <div id="upload-err">
                            <?php
                            if (isset($_SESSION['uploadInfo'])) {
                                echo $_SESSION['uploadInfo'];
                                unset($_SESSION['uploadInfo']);
                            }
                            ?>
                        </div>

                        <form action="../upload.php" method="POST" enctype='multipart/form-data'>


                            <label for="userlogo">Zmień swoje zdjęcie</label>
                            <div class="input-group">
                                <input type="file" name="fileToUpload" id="userlogo" required>
                                <button type="submit" class="btn btn-primary btn-block mt-3">Wyślij</button>
                               
                               
                               
                            </div><br>
                            Maksymalny rozmiar pliku to <strong>100 KB </strong>

                        </form>


                    </div>



                </div>





            </div>
            <div class="col-md-5 border-right">
                <form method="POST" action="zmienDane.php">
                    <div class="p-3 py-5">
                         
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="text-right">Dane osobowe</h4> <br><br>
                        </div>
                        <?php
                        if (isset($_SESSION['newDaneSuccess'])) :
                        ?>
                            <div class="alert alert-success" role="alert">
                                <i style="color: #FFF;" class="fa fa-check"></i> Operacja się powiodła
                            </div>
                        <?php
                            unset($_SESSION['newDaneSuccess']);
                        endif;
                        if (isset($_SESSION['newDaneError'])) :
                        ?>
                            <div class="alert alert-warning" role="alert" style="color: #000;">
                                <?php echo "Uwaga: " . $_SESSION['newDaneError']; ?>
                            </div>

                        <?php
                            unset($_SESSION['newDaneError']);
                        endif;
                        ?>
                        <div class="row mt-2">
                            <div class="col-md-6"><label class="labels">Imię</label><input type="text" name="nimie" class="form-control" placeholder="Imię" value="<?php echo $userDet[0]['imie']; ?>"></div>
                            <div class="col-md-6"><label class="labels">Nazwisko</label><input type="text" name="nnazwisko" class="form-control" value="<?php echo $userDet[0]['nazwisko']; ?>" placeholder="Nazwisko"></div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12"><label class="labels">Kraj</label><input type="text" name="nkraj" class="form-control" placeholder="Kraj" value="<?php echo $userDet[0]['kraj']; ?>"></div>
                            <div class="col-md-12"><label class="labels">Miasto</label><input type="text" name="nmiasto" class="form-control" placeholder="Miasto" value="<?php echo $userDet[0]['miasto']; ?>"></div>
                            <div class="col-md-12"><label class="labels">Ulica</label><input type="text" name="nulica" class="form-control" placeholder="Ulica" value="<?php echo $userDet[0]['ulica']; ?>"></div>
                        </div>

                        <div class="mt-5 text-center d-flex flex-row justify-content-center">
                            <button class="btn btn-primary mr-3" type="submit"><i class="fa fa-save"></i> Zapisz dane</button>

                        </div>
                    </div>
                </form>



            </div>
            <div class="col-md-4">
                <div class="p-3 py-5">
                    <div class="d-flex justify-content-between align-items-center" style="font-size: 17px;">

                        <?php
                        $order = new Orders();
                        $productClass = new Produkty();

                        $orders = $order->getUserOrders($conn, $_SESSION['login'], 5);
                        ?>

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Ostatnie Twoje zamówienia ze sklepu</h3>
                            </div>

                            <div class="card-body">

                                <?php

                                if (is_array($orders) && count($orders) > 0) {


                                    for ($or = 0; $or < count($orders); $or++) {



                                ?>

                                        <div id="accordion">
                                            <div class="card card-primary">
                                                <div class="card-header">
                                                    <h4 class="card-title w-100">
                                                        <a class="d-block w-100" data-toggle="collapse" href="#zamowienia-<?php echo $orders[$or]['id']; ?>">
                                                            <?php echo "Zamówienie #" . $orders[$or]['id'] . " -" . substr($orders[$or]['sesja_id'], 0, 19); ?>
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="zamowienia-<?php echo $orders[$or]['id']; ?>" class="collapse" data-parent="#accordion">
                                                    <div class="card-body">
                                                        <?php
                                                        $pro = explode("-", $orders[$or]['produkt_id']);

                                                        $ileProducts = count($pro);

                                                        echo "<strong> Zakupione produkty: </strong>  <br><br>";
                                                        for ($pp = 0; $pp < $ileProducts; $pp++) {
                                                            $ppr = $productClass->getProductDetailsById($conn, $pro[$pp]);

                                                            $ppi = $pp + 1;

                                                            echo $ppi . " - " . $ppr[0]['nazwa'] . " - Koszt: (" . $ppr[0]['cena'] . " PLN)  <br>";
                                                        }

                                                        echo "<br><span class='text-center'> <strong> Status: </strong><span>" . $order->getOrderLabel($orders[$or]['status']);



                                                        ?>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                <?php
                                    }
                                } else {
                                    echo "<strong> Brak zamówień </strong>";
                                }
                                ?>


                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->




                    </div><br>
                </div>
            </div>
        </div>

    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="ModalResetPassword" tabindex="-1" role="dialog" aria-labelledby="ModalResetPassword" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalResetPassword">Reset Hasła</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span id="nPass_err">

                </span>
                <div class="form-row">
                    <div class="col-12">
                        <label> Aktualne hasło: </label>
                        <input type="password" id="nPass_old" class="form-control">
                    </div>
                    <div class="col-12">
                        <label> Nowe hasło: </label>
                        <input type="password" id="nPass_new1" class="form-control">
                    </div>
                    <div class="col-12">
                        <label> Powtórz hasło: </label>
                        <input type="password" id="nPass_new2" class="form-control">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
                <button type="button" class="btn btn-primary" onclick="changePassword(<?php echo $userDet[0]['id']; ?>)">Zatwierdź</button>
            </div>
        </div>
    </div>
</div>


<button class="btn btn-success" id="buttonModalSuccess" style="display: none;" data-toggle="modal" data-target="#ModalSuccess"><i class="fa fa-lock"></i> Sukces </button>

<!-- Modal -->
<div class="modal fade" id="ModalSuccess" tabindex="-1" role="dialog" aria-labelledby="ModalSuccess" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalTitleSuccess">Sukces!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-center">
                    <h5> <strong> Operacja wykonana poprawnie! </strong> </h5> <br><br>
                </div>
                <center> <i style="color: green; font-size: 45px;" class="fa fa-check"></i> </center>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
            </div>
        </div>
    </div>
</div>



</div>



<?php
include('../footer.php');
?>