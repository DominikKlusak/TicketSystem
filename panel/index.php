<?php
session_start();
include('../sklep/navigacja.php');
$tab = 2;

if (isset($_SESSION['zalogowany'])) {

  if ($_SESSION['zalogowany'] == true) {

      header('Location: pages/main.php');

  }

}

?>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Sklep</title>
    <!-- BOOSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="../panel/admin/plugins/fontawesome-free/css/all.css">
    <link rel="stylesheet" href="../panel/admin/dist/css//adminlte.css">
    <link href="css/style.css" rel="stylesheet" />
</head>
<nav class="navbar fixed-top navbar-expand-sm navbar-light bg-light">
    <div class="container px-4 px-lg-5">
        <a class="navbar-brand" href="index.php">Sklep</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                <li class="nav-item"><a class="nav-link <?php if ($tab == 1) : echo "active";
                                                        endif; ?>" aria-current="page" href="../sklep/index.php">Strona Główna</a></li>
                <li class="nav-item"><a class="nav-link <?php if ($tab == 2) : echo "active";
                                                        endif; ?>" href="index.php">Zaloguj się</a></li>
                <li class="nav-item"><a class="nav-link <?php if ($tab == 3) : echo "active";
                                                        endif; ?>" href="../sklep/rejestracja.php">Zarejestruj się</a></li>
                <li class="nav-item"><a class="nav-link <?php if ($tab == 4) : echo "active";
                                                        endif; ?>" href="../sklep/kontakt.php">Kontakt</a></li>
            </ul>

            <a href="../sklep/koszyk.php" class="btn btn-outline-dark mr-4">
                <i class="fa fa-shopping-cart"></i>
                Koszyk
                <span class="badge bg-primary text-white ms-1 rounded-pill">

                    <?php

                    echo $produkty->getCartItems($conn, $token, true);
                    ?>
                </span>
            </a>

            <button class="btn btn-outline-dark" data-toggle="collapse" data-target="#chat" aria-expanded="false" aria-controls="chat">
                <i class="fa fa-comments"></i> Chat
                <span id="countMesseges" class="badge bg-danger text-white ms-1 rounded-pill">0</span>
            </button>


            <div class="collapse" id="chat" style="padding: 0; height: auto;  width: 500px; position: absolute; top:60px; right: 50px; z-index: 120;">

                <div class="card card-primary card-outline direct-chat">
                    <div class="card-header">
                        <h3 class="card-title">Czat - <?php echo session_id(); ?></h3>
                    </div>

                    <div class="card-body">
                        <div class="direct-chat-messages" id="chat-<?php echo session_id(); ?>">

                            <div class="direct-chat-msg">
                                <div class="direct-chat-infos clearfix">
                                    <span class="direct-chat-name float-left">Administracja</span>
                                    <span class="direct-chat-timestamp float-right"><?php echo date('Y-m-d H:i:s') ?></span>
                                </div>
                                <img class="direct-chat-img" src="../panel/img/avatar2.png" alt="Avatar3">
                                <div class="direct-chat-text">
                                    Cześć! Postaramy się odpisać jak tylko któryś z pracowników będzie dostępny. <br>
                                    Nie wyłączaj przeglądarki, a gdybyś czekał/a dłużej zostaw do siebie kontakt.
                                </div>
                            </div>

                            <?php
                            $messClass = new Messages();
                            $classUser = new Users();

                            $wiadomosc = $messClass->getMessegesBySession($conn, session_id());

                            $ileWiadomosci = count($wiadomosc);

                           

                                for ($rr = 0; $rr < $ileWiadomosci; $rr++) {

                                    $imie = (isset($wiadomosc[$rr]['imie'])) ? $wiadomosc[$rr]['imie'] : "Ja";
                                    $zdjecie = (isset($wiadomosc[$rr]['zdjecie'])) ? $wiadomosc[$rr]['zdjecie'] : "img/default.png";
                                    $message = $wiadomosc[$rr]['wiadomosc'];
                                    $data_add = $wiadomosc[$rr]['data_add'];

                            ?>


                                       <div class="direct-chat-msg">
                                                <div class="direct-chat-infos clearfix">
                                                    <span class="direct-chat-name float-left"><?php echo $imie; ?></span>
                                                    <span class="direct-chat-timestamp float-right"><?php echo $data_add; ?></span>
                                                </div>
                                                <img class="direct-chat-img" src="../panel/<?php echo $zdjecie; ?>" alt="Avatar3">
                                                <div class="direct-chat-text"><?php echo $message; ?></div>
                                        </div>

                                   
                            <?php
                                    
                                }



                            ?>


                        </div>

                    </div>

                    <div class="card-footer">
                        <div class="input-group">
                            <input type="text" id="chatMessage" placeholder="Napisz coś ..." class="form-control">
                            <span class="input-group-append">
                                <button onclick="sendMessage();" class="btn btn-primary">Wyślij</button>
                            </span>
                        </div>
                    </div>



                </div>



            </div>




        </div>
    </div>


</nav>



<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href=""><b>Panel</b> Sklepu</a>
  </div>
  <div class="card">
    <div class="card-body login-card-body">
     
      <p class="login-box-msg">Zaloguj się na swoje konto!</p>
        <?php
            if (isset($_SESSION['loginError'])):
        ?>
                <p style="color: red; font-weight: bold;" class="mb-2 mt-3 text-center">
                    <?php echo $_SESSION['loginError'];  ?>
                </p>
        <?php
                unset($_SESSION['loginError']);
            endif;
        ?>

      <form action="login/loginController.php" method="post">
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="haslo" class="form-control" placeholder="Hasło">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-success btn-block"><i class="fa fa-arrow-right" aria-hidden="true"></i> Zaloguj się!</button>
          </div>
        </div>
      </form>

      <p class="mb-2 mt-3">
        <a href="../sklep/rejestracja.php" class="text-center">Nie masz konta? Zarejestruj się!</a> <br><br>
        <a href="../sklep" class="text-center"> << Powrót do sklepu</a> 
      </p>
    </div>
   
  </div>
</div>


<!-- jQuery -->
<script src="admin/plugins/jquery/jquery.js"></script>
<!-- Bootstrap 4 -->
<script src="admin/plugins/bootstrap/js/bootstrap.js"></script>
</body>
</html>
