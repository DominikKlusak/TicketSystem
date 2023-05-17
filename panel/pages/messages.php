<?php
include('../header.php');

if ($_SESSION['zalogowany'] !== true) {
    header('Location: index.php');
    exit(0);
}
if (!$user->isAdmin($conn, $_SESSION['id']))
{
    header('Location: main.php');
    exit(0);
}

include('../functions.php');

// Pobieranie wiadomości ze skrzynki mailowej
$database = new Database();
$connect = $database->connect();

$wiadomosci = new Messages();

$wiadomosci->UpdateEmails($connect);


?>


<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-danger card-outline">
                    <div class="card-body">
                        <h5 class="card-title mb-5">Wiadomości</h5>

                        <div class="table-responsive">

                            <table id="tabWiad" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Kanał</th>
                                        <th>Email</th>
                                        <th>Temat</th>
                                        <th>Data wysłania</th>
                                        <th>Opcje</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                        $wiad = $wiadomosci->getAllEmails($connect);

                                       if (is_array($wiad))
                                       {

                                            if (count($wiad) > 0)
                                            {

                                                for ($v = 0; $v < count($wiad); $v++)
                                                {
                                                        $kanal = "";
                                                        if ($wiad[$v]['kanal'] == "EMAIL") {

                                                            $kanal = "<span style='color: red; font-weight:bold;'> <i class='fa fa-envelope'></i> ".$wiad[$v]['kanal']."</span>";

                                                        } else if ($wiad[$v]['kanal'] == "FORMULARZ") {

                                                            $kanal = "<strong> <i class='fa fa-file'></i> ".$wiad[$v]['kanal']."</strong>";

                                                        } else if ($wiad[$v]['kanal'] == "CHAT") {

                                                            $kanal = "<span style='color: purple; font-weight:bold;'><i class='fa fa-comments'></i> ".$wiad[$v]['kanal']."</span>";

                                                        }
                                    ?>

                                                    <tr>
                                                        <td><?php echo $wiad[$v]['id']; ?></td>
                                                        <td><?php echo $kanal;  ?></td>
                                                        <td><?php echo $wiad[$v]['email'];  ?></td>
                                                        <td><?php echo how_len($wiad[$v]['temat'], 20);  ?></td>
                                                        <td><?php echo $wiad[$v]['kiedy_wyslano'];  ?></td>
                                                        <td>
                                                            <a href="zobaczKontakt.php?id=<?php echo $wiad[$v]['id']; ?>" data-toggle='tooltip' data-placement='top' title='' data-original-title='Szczegóły' class="btn btn-primary btn-sm btn-block" href="#"><i class="fas fa-eye"></i></a>
                                                        </td>
                                                    </tr>

                                    <?php
                                                }
                                            }
                                       }
                                    ?>

                                    </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col-md-6 -->

        </div>
    </div>
</div>
</div>


<?php
include('../footer.php');
?>