<?php
include('../header.php');

if ($_SESSION['zalogowany'] !== true) {
    header('Location: ../index.php');
    exit(0);
}

if (!isset($_REQUEST['id'])) {
    header('Location: main.php');
    exit(0);
}


?>

<style>
    .list-item {
        position: relative;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-direction: column;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word
    }

    .list-item.block .media {
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0
    }

    .list-item.block .list-content {
        padding: 1rem
    }

    .w-40 {
        width: 40px !important;
        height: 40px !important
    }

    .avatar {
        position: relative;
        line-height: 1;
        border-radius: 500px;
        white-space: nowrap;
        font-weight: 700;
        border-radius: 100%;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-pack: center;
        justify-content: center;
        -ms-flex-align: center;
        align-items: center;
        -ms-flex-negative: 0;
        flex-shrink: 0;
        border-radius: 500px;
        box-shadow: 0 5px 10px 0 rgba(50, 50, 50, .15)
    }

    .avatar img {
        border-radius: inherit;
        width: 100%
    }

    .gd-primary {
        color: #fff;
        border: none;
        background: #448bff linear-gradient(45deg, #448bff, #44e9ff)
    }

    .flex {
        -webkit-box-flex: 1;
        -ms-flex: 1 1 auto;
        flex: 1 1 auto
    }

    .text-color {
        color: #5e676f
    }

    .text-sm {
        font-size: .825rem
    }

    .h-1x {
        height: 1.25rem;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical
    }

    .no-wrap {
        white-space: nowrap
    }

    .list-row .list-item {
        -ms-flex-direction: row;
        flex-direction: row;
        -ms-flex-align: center;
        align-items: center;
        padding: .75rem .625rem;
    }

    .list-item {
        position: relative;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-direction: column;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
    }

    .list-row .list-item>* {
        padding-left: .625rem;
        padding-right: .625rem;
    }

    .dropdown {
        position: relative;
    }

    a:focus,
    a:hover {
        text-decoration: none;
    }

    list-item {
        background: white;
    }
</style>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-danger card-outline">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <h5 class="card-title mb-5">Szczegóły zamówienia #<?php echo $_REQUEST['id']; ?></h5>
                            </div>
                            <div class="col-6">
                                <div class="d-flex justify-content-end">

                                    <button type="button" class="btn btn-success mr-3" onclick="saveZam(<?php echo $_REQUEST['id']; ?>)"><i class="fa fa-save"></i> Zapisz zmiany </button>
                                    <button type="button" class="btn btn-primary mr-3" data-toggle="modal" data-target="#modalPrzydzielPrac"><i class="fa fa-users"></i> Przydziel opiekuna </button>
                                    <button type="button" class="btn btn-secondary mr-3" data-toggle="modal" data-target="#modalNapiszMaila"><i class="fa fa-envelope"></i> Wyślij e-mail </button>
                                    <!-- <button type="button" class="btn btn-danger mr-3" data-toggle="modal" data-target="#modalZatwierdzAnul"><i class="fa fa-trash"></i> Anuluj </button> -->


                                </div>
                            </div>

                        </div>


                        <div class="row mt-5">

                            <div class="col-lg-8">

                                <?php
                                $db = new Database();
                                $conn = $db->connect();
                                $order = new Orders();
                                $pro = new Produkty();

                                $zamowienie = $order->getOrderById($conn, $_REQUEST['id']);

                                //var_dump($zamowienie);

                                ?>

                                <div class="controls p-3 border-right">

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="form_email">Data złożenia </label>
                                                <input type="text" value="<?php echo $zamowienie[0]['data_zam']; ?>" class="form-control" required="required" disabled>

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <label>Sesja użytkownika</label>
                                                    <input type="text" value="<?php echo $zamowienie[0]['sesja_id']; ?>" class="form-control" required="required" disabled>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Imię</label>
                                                <input type="text" value="<?php echo $zamowienie[0]['imie']; ?>" id="uimie" class="form-control" required="required">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nazwisko</label>
                                                <input type="text" value="<?php echo $zamowienie[0]['nazwisko']; ?>" id="unazwisko" class="form-control" required="required">
                                            </div>
                                        </div>




                                    </div>



                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="form_need">Kurier</label>
                                                <select id="ukurier" class="form-control" required="required">
                                                    <?php
                                                    $kurier = ($zamowienie[0]['kurierDPD'] == "tak") ? "<option>Kurier DPD</option>" : "<option>Kurier Inpost</option>";
                                                    ?>
                                                    <option value="value=" <?php echo $kurier; ?>" selected disabled>--Wybierz kuriera--</option>
                                                    <option value="KurierDPD">Kurier DPD</option>
                                                    <option value="KurierINPOST">Kurier Inpost</option>
                                                </select>

                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <label>Kraj</label>
                                                    <input type="text" value="<?php echo $zamowienie[0]['kraj']; ?>" id="ukraj" class="form-control" required="required">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="form_email">Miasto </label>
                                                <input type="text" id="umiasto" value="<?php echo $zamowienie[0]['miasto']; ?>" class="form-control" required="required">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <label>Ulica</label>
                                                    <input type="text" id="uulica" value="<?php echo $zamowienie[0]['ulica']; ?>" class="form-control" required="required">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="form_message">Uwagi</label>
                                                <textarea id="uuwagi" class="form-control" rows="4"><?php echo $zamowienie[0]['uwagi']; ?></textarea>
                                            </div>

                                        </div>
                                    </div>

                                </div>

                            </div>



                            <div class="col-lg-4">

                                <?php
                                //var_dump($zamowienie[0]['produkt_id']);

                                $produkty = explode('-', $zamowienie[0]['produkt_id']);

                                $ileProduktow = count($produkty);

                                echo "<div class='row mb-3'> ";
                                echo "<span style='font-weight: bold; font-size: 18px;'> Zakupione produkty: </span>";
                                echo "</div> ";

                                for ($ii = 0; $ii < $ileProduktow; $ii++) {

                                    $produkt = $pro->getProductDetailsById($conn, $produkty[$ii]);
                                    echo "<div class='row mb-3'> ";
                                    echo "<div class='col-4'> ";
                                    echo "<img style='width:80%; height: auto;' src=../../sklep/" . $produkt[0]['zdjecie'] . " alt='zdjecie'/>";
                                    echo "</div> ";
                                    echo "<div class='col-4'> ";
                                    echo "<span>" . $produkt[0]['nazwa'] . "</span>";
                                    echo "</div> ";

                                    echo "<div class='col-4'> ";
                                    echo "<span>" . $produkt[0]['cena'] . " PLN </span>";
                                    echo "</div> ";
                                    echo "</div> ";
                                }
                                echo "<hr>
                                        <span style='font-weight: bold; font-size: 18px;'> Status: </span>
                                    ";
                                echo $order->getOrderLabel($zamowienie[0]['status']);
                                ?>
                                <button type="button" class="btn btn-block bg-gradient-info btn-sm" data-toggle="modal" data-target="#modalZmienStatus"> Zmień status </button>
                            </div>


                        </div>
                        <hr>
                        <div class="row mt-3">

                            <div class="col-lg-8">

                                <h3> Historia zmian </h3>

                                <div class="d-flex">

                                    <?php
                                    $users = new Users();

                                    $user = $users->getUserDetailsByid($conn, $zamowienie[0]['user_login']);
                                    $zdjecie = ($users->getUserPhoto($conn, $zamowienie[0]['user_login']) != null) ? $users->getUserPhoto($conn, $zamowienie[0]['user_login']) : "img/default.png";

                                    $dane = $zamowienie[0]['imie'] . " " . $zamowienie[0]['nazwisko'];

                                    $log = new Log();

                                    $historia = $log->getHistoryLog($conn, $zamowienie[0]['id'], $_SESSION['id']);
                                    ?>

                                    <div class="list list-row">

                                        <div class="list-item">
                                            <div><span class="w-40 avatar gd-success"><img src="../<?php echo $zdjecie; ?>" alt="avatar"></span></div>
                                            <div class="flex">
                                                <a href="#" class="item-author text-color" data-abc="true"><?php echo $dane; ?></a>
                                                <div class="item-except text-sm h-1x" style="color: green;"> Złożono zamówienie </div>
                                            </div>
                                            <div class="no-wrap">
                                                <div class="item-date text-muted text-sm d-none d-md-block"><?php echo $zamowienie[0]['data_zam']; ?></div>
                                            </div>

                                        </div>

                                        <?php
                                        if (is_array($historia) && !empty($historia)) {

                                            $ileHist = count($historia);

                                            for ($xx = 0; $xx < $ileHist; $xx++) {
                                        ?>
                                                <div class="list-item">
                                                    <div><span class="w-40 avatar gd-success"><img src="../<?php echo $historia[$xx]['zdjecie']; ?>" alt="avatar"></span></div>
                                                    <div class="flex">
                                                        <a href="#" class="item-author text-color"> <?php echo $historia[$xx]['imie']; ?> </a>
                                                        <div class="item-except text-muted text-sm h-1x"> <?php echo $historia[$xx]['czynnosc']; ?></div>
                                                    </div>
                                                    <div class="no-wrap">
                                                        <div class="item-date text-muted text-sm d-none d-md-block"> <?php echo $historia[$xx]['data_czynnosci']; ?> </div>
                                                    </div>

                                                </div>
                                        <?php
                                            }
                                        }
                                        ?>

                                    </div>


                                </div>


                            </div>


                        </div>



                    </div>
                </div>
            </div>
            <!-- /.col-md-6 -->
        </div>
    </div>
</div>





<!-- Modal ZAPIS ZAMOWIENIA -->
<div class="modal fade" id="modalSaveZam" tabindex="-1" role="dialog" aria-labelledby="modalSaveZam" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Zamówienie</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalSaveZamBody">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal PRZYDZIELENIE PRACOWNIKA -->
<div class="modal fade" id="modalPrzydzielPrac" tabindex="-1" role="dialog" aria-labelledby="modalPrzydzielPrac" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Zamówienie</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalPrzydzielPracBody">
                <div class="form-group">
                    <label for="opiekunZamowienia">Przydziel Pracownika</label>
                    <select id="opiekunZamowienia" class="form-control">
                        <?php
                        $admins = $users->getAdminList($conn);
                        if (is_array($admins) && !empty($admins)) {


                            $ileAdmins = count($admins);
                            for ($ww = 0; $ww < $ileAdmins; $ww++) {
                                echo "<option value=" . $admins[$ww]['imie'] . ">" . $admins[$ww]['imie'] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
                <button type="button" class="btn btn-success" onclick="przydzielPracownika(<?php echo $zamowienie[0]['id']; ?>)"> Zapisz</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal PRZYDZIELENIE NAPISZ MAILA -->
<div class="modal fade" id="modalNapiszMaila" tabindex="-1" role="dialog" aria-labelledby="modalNapiszMaila" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalNapiszMaila">Zamówienie</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalNapiszMailaBody">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" value="<?php echo $zamowienie[0]['user_login']; ?>" id="email-email" placeholder="Enter email">
                </div>
                <div class="form-group">
                    <label>Wiadomość:</label>
                    <textarea class="form-control" id="email-wiadomosc" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
                <button type="button" class="btn btn-success" onclick="WyslijMaila(<?php echo $zamowienie[0]['id']; ?>)"> Wyślij </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal PRZYDZIELENIE ZATWIERDŹ ANUL -->
<div class="modal fade" id="modalZatwierdzAnul" tabindex="-1" role="dialog" aria-labelledby="modalZatwierdzAnul" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalZatwierdzAnul">Zamówienie</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalZatwierdzAnulBody">
                <h3> Czy na pewno anulować zamówienie? </h3>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
                <button type="button" class="btn btn-danger" onclick="ZatwierdzAnul()"> Potwierdzam </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal PRZYDZIELENIE PRACOWNIKA -->
<div class="modal fade" id="modalZmienStatus" tabindex="-1" role="dialog" aria-labelledby="modalZmienStatus" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Zamówienie</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalZmienStatusBody">
                <div class="form-group">
                    <label for="newZamStatus">Zmień Status</label>
                    <select id="newZamStatus" class="form-control">
                        <option value="złożone">Złożone</option>
                        <option value="wysłane">Wysłane</option>
                        <option value="anulowane">Anulowane</option>
                        <option value="zrealizowane">Zrealizowane</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
                <button type="button" class="btn btn-success" onclick="ZmienStatus(<?php echo $zamowienie[0]['id']; ?>)"> Zapisz</button>
            </div>
        </div>
    </div>
</div>





</div>






<?php
include('../footer.php');
?>

<script>
    function ZmienStatus(id) {

        var status = $('#newZamStatus').val();

        $.ajax({
            url: '../actions.php',
            data: {
                action: 'ZmienStatus',
                id: id,
                status: status
            },
            type: 'post',

            success: function(output) {
                if (output == 1) {
                    location.reload(true);
                } else {
                    alert(output);
                }
            }
        });

    }


    function WyslijMaila(id) {


        var email = $('#email-email');
        var wiadomosc = $('#email-wiadomosc');

        if (email.val() != '') {
            if (wiadomosc.val() != '') {

                $.ajax({
                    url: '../actions.php',
                    data: {
                        action: 'WyslijMaila',
                        id: id,
                        wiadomosc: wiadomosc.val(),
                        email: email.val()
                    },
                    type: 'post',

                    success: function(output) {
                        if (output == 1) {
                            alert('Wiadomość wysłana poprawnie.');
                        } else {
                            alert(output);
                        }
                    }
                });


            } else {
                wiadomosc.css('border', '1px solid red');
            }



        } else {
            email.css('border', '1px solid red');
        }
    }

    function przydzielPracownika(id) {
        var opiekun = $('#opiekunZamowienia').val();

        $.ajax({
            url: '../actions.php',
            data: {
                action: 'przydzielPracownika',
                id: id,
                opiekun: opiekun

            },
            type: 'post',

            success: function(output) {
                if (output == 1) {
                    location.reload(true);
                } else {
                    alert(output);
                }
            }
        });

    }

    function saveZam(id) {

        var err = 0;
        var arr = ['imie', 'nazwisko', 'kurier', 'kraj', 'miasto', 'ulica'];

        for (var p = 0; p < arr.length; p++) {

            if ($('#u' + arr[p]).val() == "") {

                $('#u' + arr[p]).css('border', '1px solid red');
                err++;
            }

        }


        if (id != '') {

            if (err == 0) {


                $.ajax({
                    url: '../actions.php',
                    data: {
                        action: 'saveZam',
                        id: id,
                        imie: $('#uimie').val(),
                        nazwisko: $('#unazwisko').val(),
                        kurier: $('#ukurier').val(),
                        kraj: $('#ukraj').val(),
                        miasto: $('#umiasto').val(),
                        ulica: $('#uulica').val(),
                        uwagi: $('#uuwagi').val(),
                    },
                    type: 'post',

                    success: function(output) {
                        if (output == 1) {
                            location.reload(true);
                        }
                    }
                });
            }



        }

    }
</script>