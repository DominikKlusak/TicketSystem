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
</head>

<body>
    <!-- Nawigacja-->
    <?php
    $tab = 4;
    include('navigacja.php');
    include('header.php');
    ?>
    <section>
        <div class="container">
            <div class="row justify-content-center mt-5">
                <div class="col-md-6 text-center mb-11">
                    <h2 class="heading-section">Kontakt</h2>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-10 col-md-12">
                    <div class="wrapper" style="color: #FFF;">
                        <div class="row">
                            <div class="col-md-7 d-flex align-items-stretch">
                                <div class="contact-wrap w-100 p-md-5 p-4">

                                    <h3 class="mb-4" style="color: #000;">Pozostańmy w kontakcie!</h3>

                                    <?php
                                    if (isset($_SESSION['kontaktSuccess'])) {

                                        echo '
                                            <div class="alert alert-success" role="alert">
                                            <strong> Wiadomość została przesłana! </strong> <br>
                                             Odpiszemy tak szybko jak będzie to możliwe. 
                                            </div>';

                                        unset($_SESSION['kontaktSuccess']);
                                    } else if (isset($_SESSION['kontaktError'])) {

                                        echo '<div class="alert alert-danger" role="alert">
                                              ' . $_SESSION['kontaktError'] . '
                                        </div>';

                                        unset($_SESSION['kontaktError']);
                                    }


                                    ?>

                                    <form method="POST" action="formularze/kontaktController.php">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="cimie" placeholder="Imię">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="email" class="form-control" name="cemail" placeholder="Email">
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-3">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="ctemat" placeholder="Temat">
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-3">
                                                <div class="form-group">
                                                    <textarea name="cwiadomosc" class="form-control" cols="30" rows="7" placeholder="Wiadomość"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-4">
                                                <div class="form-group">
                                                    <input type="submit" value="Wyślij wiadomość" class="btn btn-primary">
                                                </div>
                                            </div>
                                        </div>
                                    </form>



                                </div>
                            </div>
                            <div class="col-md-5 d-flex align-items-stretch">
                                <div class="info-wrap bg-primary w-100 p-lg-5 p-4">
                                    <h3 class="mb-4 mt-md-4">Skontaktuj się z nami!</h3>
                                    <div class="dbox w-100 d-flex align-items-start">
                                        <div class="icon d-flex align-items-center justify-content-center">
                                            <span class="fa fa-map-marker"></span>
                                        </div>
                                        <div class="text pl-3">
                                            <p><span>Adres:</span> ul. Testowa 3B, 00-000 Warszawa</p>
                                        </div>
                                    </div>
                                    <div class="dbox w-100 d-flex align-items-center">
                                        <div class="icon d-flex align-items-center justify-content-center">
                                            <span class="fa fa-phone"></span>
                                        </div>
                                        <div class="text pl-3">
                                            <p><span>Telefon:</span> 32 34 49 115</p>
                                        </div>
                                    </div>
                                    <div class="dbox w-100 d-flex align-items-center">
                                        <div class="icon d-flex align-items-center justify-content-center">
                                            <span class="fa fa-paper-plane"></span>
                                        </div>
                                        <div class="text pl-3">
                                            <p><span>Email:</span><strong> mojnowysklep1@interia.pl </strong> </p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
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