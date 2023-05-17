<?php
include('../header.php');

if ($_SESSION['zalogowany'] !== true) {
    header('Location: ../index.php');
    exit(0);
}

if (!$user->isAdmin($conn, $_SESSION['id']))
{
    header('Location: main.php');
    exit(0);
}

?>




<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-danger card-outline">
                    <div class="card-body">
                        <h5 class="card-title mb-5">Zamówienia</h5>
                        
                        
                                <div class="table-responsive">

                                    <table id="tabZam" class="table table-bordered table-striped users-table">
                                        <thead>
                                            <tr>
                                                <th>#ID</th>
                                                <th>Imię i nazwisko</th>
                                                <th>Kraj</th>
                                                <th>Miasto</th>
                                                <th>Ulica</th>
                                                <th>Status</th>
                                                <th>Opcje</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $db = new Database();
                                                $connect = $db->connect();
                                                $ord = new Orders();

                                                $zamowienia = $ord->getAllOrders($connect);

                                                $ile = count($zamowienia);

                                                if ($ile > 0) {

                                                    for ($x = 0; $x < $ile; $x++)
                                                    {
                                                        $idZam = $zamowienia[$x]['id'];

                                            ?>
                                        
                                                    <tr <?php echo ""; ?>>
                                                        <td><?php echo $idZam; ?></td>
                                                        <td><?php echo $zamowienia[$x]['imie']." ".$zamowienia[$x]['nazwisko'];  ?></td>
                                                        <td><?php echo $zamowienia[$x]['kraj'];  ?></td>
                                                        <td><?php echo $zamowienia[$x]['miasto'];  ?></td>
                                                        <td><?php echo $zamowienia[$x]['ulica'];  ?></td>
                                                        <td><?php echo $ord->getOrderLabel($zamowienia[$x]['status']);  ?></td>
                                                        <td class="options">
                                                            <a data-toggle='tooltip' data-placement='top' title='' data-original-title='Szczegóły' class="btn btn-primary btn-sm btn-block" href="ordersInfo.php?id=<?php echo $idZam; ?>"><i class="fas fa-eye"></i></a>

                                                        </td>
                                                    </tr>
                                            <?php
                                                    }
                                                }
                                            ?>
                                            <tfoot></tfoot>
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