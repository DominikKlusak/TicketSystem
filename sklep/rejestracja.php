<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <style>

                .card {
                padding: 30px 40px;
                margin-top: 60px;
                margin-bottom: 60px;
                border: none !important;
                box-shadow: 0 6px 12px 0 rgba(0, 0, 0, 0.2)
                }

                .btn-block {
                text-transform: uppercase;
                font-size: 15px !important;
                font-weight: 400;
                height: 43px;
                cursor: pointer
                }

                .btn-block:hover {
                color: #fff !important
                }

                button:focus {
                -moz-box-shadow: none !important;
                -webkit-box-shadow: none !important;
                box-shadow: none !important;
                outline-width: 0
                }


    </style>
</head>

<body>
    <?php 
        $tab = 3;
        include('navigacja.php');
        include('header.php');
    ?>



    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-3 d-flex justify-content-center">
            <div class="container-fluid px-1 py-3 mx-auto">
                <div class="row d-flex justify-content-center">
                    <div class="col-xl-7 col-lg-8 col-md-9 col-11 text-center">
                        <h3>Zarejestruj się</h3>
                        <div class="card">
                            <?php
                                if (isset($_SESSION['registerError'])) {
                            ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo $_SESSION['registerError']; ?>
                                </div>
                            <?php
                                    unset($_SESSION['registerError']);
                                }
                                else if (isset($_SESSION['registerSuccess']))
                                {
                            ?>
                                    <div class="alert alert-success" role="alert">
                                        Konto zostało pomyślnie utworzone!<br>
                                        Możesz się zalogować <a style="color: #000;" href="login.php"> Tutaj </a>
                                    </div>
                            <?php
                                     unset($_SESSION['registerSuccess']);
                                }
                            ?>
                            <form method="POST" action="formularze/registerController.php">
                                <div class="row justify-content-between text-left mt-4">
                                    <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-3">Imię <span class="text-danger"> *</span></label> <input class="form-control" type="text" name="rimie" placeholder="Wpisz swoję imię"> </div>
                                    <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-3">Nazwisko <span class="text-danger"> *</span></label> <input class="form-control" type="text" name="rnazwisko" placeholder="Wpisz swoje nazwisko"> </div>
                                </div>
                                <div class="row justify-content-between text-left mt-4">
                                <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-3">Email <span class="text-danger">*</span></label> <input class="form-control" type="text" name="remail" placeholder="Twój e-mail"> </div>
                                    <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-3">Hasło: <span class="text-danger"> *</span></label> <input class="form-control" type="text" name="rhaslo" placeholder="Wpisz swoje hasło"> </div>
                                </div>
                                

                                <div class="row justify-content-between text-left mt-4">
                                    <div class="form-group col-4 flex-column d-flex"> <label class="form-control-label px-3">Miasto <span class="text-danger">*</span></label> <input class="form-control" type="text" name="rmiasto" placeholder="Miasto"> </div>
                                    <div class="form-group col-4 flex-column d-flex"> <label class="form-control-label px-3">Kraj <span class="text-danger">*</span></label> <input class="form-control" type="text" name="rkraj" placeholder="Kraj"> </div>
                                    <div class="form-group col-4 flex-column d-flex"> <label class="form-control-label px-3">Ulica <span class="text-danger">*</span></label> <input class="form-control" type="text" name="rulica" placeholder="Ulica"> </div>
                                </div>
                              
                                    <div class="form-group col-sm-12 d-flex justify-content-end mt-4">
                                         <button type="submit" class="btn-block btn-lg btn-primary">Rejestruj!</button> 
                                    </div>
                                
                            </form>
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