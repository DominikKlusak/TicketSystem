<?php
session_start();
spl_autoload_register(function ($class) {
    include 'classes/' . $class . '.class.php';
});

$user = new Users();
$db = new Database();
$conn = $db->connect();

?>
<!DOCTYPE html>
<html lang="pl-PL">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Panel Sklepu </title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

  <link rel="stylesheet" href="../admin/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../admin/dist/css/adminlte.css">
  <link rel="stylesheet" href="../admin/plugins/datatables-buttons/css/buttons.bootstrap4.css">
  <link rel="stylesheet" href="../admin/plugins/datatables-select/css/select.bootstrap4.css">
  <link rel="stylesheet" href="../admin/plugins/datatables/jquery.DataTables.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Główny Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Logo -->
    <a href="main.php" class="brand-link">
      <img src="../img/logo.png" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Panel</span>
    </a>

    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php echo '../'.$user->getUserPhoto($conn, $_SESSION['id']); ?>" class="img-circle elevation-2" alt="Zdjecie">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $_SESSION['imie']." ".$_SESSION['nazwisko']; ?></a>
        </div>
      </div>

      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          
          <li class="nav-item">
            <a href="main.php" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p> Strefa Klienta </p>
            </a>
          </li>
          <?php
              if ($user->isAdmin($conn, $_SESSION['id']))
              {
          ?>
          <li class="nav-item">
            <a href="orders.php" class="nav-link">
              <i class="nav-icon fas fa-credit-card"></i>
              <p> Zamówienia</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="messages.php" class="nav-link">
              <i class="nav-icon fas fa-envelope"></i>
              <p> Wiadomości </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="users.php" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p> Użytkownicy </p>
            </a>
          </li>
          <?php
              }
          ?>



        </ul>
      </nav>
    </div>
  </aside>

  <div class="content-wrapper">
        <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Panel sklepu</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"> <a href="../login/logout.php" class="btn btn-sm btn-danger"><i class="fa fa-lock"></i> Wyloguj  </a> </li>
                </ol>
            </div>
            </div>
        </div>
        </div>