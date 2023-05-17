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

$database = new Database();
$connect = $database->connect();

$users = new Users();
?>


<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-danger card-outline">
                    <div class="card-body">
                        <h5 class="card-title">Użytkownicy</h5> <br> <br>
                        <button class="btn btn-success" data-toggle="modal" data-target="#addUser-modal-lg"><i class="fa fa-plus"></i> Dodaj użytkownika </button>
                        <br><br>
                        <div class="table-responsive">

                            <table id="tabUsers" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#ID</th>
                                        <th>Login</th>
                                        <th>Imię i nazwisko</th>
                                        <th>Miasto</th>
                                        <th>Ulica</th>
                                        <th>Kraj</th>
                                        <th>Opcje</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php

                                    $user = $users->getAllUsers($connect);


                                    if (count($user) > 0) {

                                        for ($u = 0; $u < count($user); $u++) {

                                            $login = ($users->isAdmin($connect, $user[$u]['id'])) ? "<span style='color: red; font-weight: bold;'>" . $user[$u]['login'] . "</span>" : $user[$u]['login'];
                                    ?>

                                            <tr>
                                                <td><?php echo $user[$u]['id']; ?></td>
                                                <td><?php echo $login;  ?></td>
                                                <td><?php echo $user[$u]['imie'] . " " . $user[$u]['nazwisko'];  ?></td>
                                                <td><?php echo $user[$u]['miasto'];  ?></td>
                                                <td><?php echo $user[$u]['ulica'];  ?></td>
                                                <td><?php echo $user[$u]['kraj']; ?></td>
                                                <td>
                                                    <button class="btn btn-primary btn-sm" onclick="getUser(<?php echo $user[$u]['id']; ?>)"><i class="fas fa-eye"></i> </button>
                                                    <button id="modalEditBtn" data-toggle="modal" data-target="#editUser-modal-lg" style="display: none;">modal edit</button>
                                                    <button onclick="delUser(<?php echo $user[$u]['id']; ?>)" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                                </td>
                                            </tr>

                                    <?php
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




<div class="modal fade" id="addUser-modal-lg" tabindex="-1" role="dialog" aria-labelledby="addUser-modal-lg" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Dodaj użytkownika</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Imię:</label>
                            <input type="text" id="a-imie" class="form-control" placeholder="Imię">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nazwisko:</label>
                            <input type="text" id="a-nazwisko" class="form-control" placeholder="Nazwisko">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Login:</label>
                            <input type="email" id="a-login" class="form-control" placeholder="Login (email)">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Hasło</label>
                            <input type="password" id="a-haslo" class="form-control" placeholder="Hasło">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Administrator:</label>
                            <select id="a-admin" class="form-control" id="newUser-admin">
                                <option value="nie">NIE</option>
                                <option value="tak">TAK</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Miasto:</label>
                            <input id="a-miasto" type="text" class="form-control" placeholder="Miasto">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Kraj:</label>
                            <input id="a-kraj" type="text" class="form-control" placeholder="Kraj">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Ulica:</label>
                            <input id="a-ulica" type="text" class="form-control" placeholder="Ulica">
                        </div>
                    </div>


                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
                <button type="button" onclick="addNewUser()" class="btn btn-success">Dodaj</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="editUser-modal-lg" tabindex="-1" role="dialog" aria-labelledby="editUser-modal-lg" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edytuj użytkownika</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalBodyEditUser">




            </div>
        </div>
    </div>
</div>





</div>


<?php
include('../footer.php');
?>

<script>
    function addNewUser() {

        var err = 0;
        var tab = ['imie', 'login', 'haslo'];

        for (var tt = 0; tt < tab.length; tt++) {

            if ($('#a-' + tab[tt]).val() == '') {
                err++;
                $('#a-' + tab[tt]).css('border', '1px solid red');
            }


        }

        if (err == 0) {

            $.ajax({
                url: '../actions.php',
                data: {
                    action: 'addNewUser',
                    imie: $('#a-imie').val(),
                    nazwisko: $('#a-nazwisko').val(),
                    login: $('#a-login').val(),
                    haslo: $('#a-haslo').val(),
                    miasto: $('#a-miasto').val(),
                    kraj: $('#a-kraj').val(),
                    ulica: $('#a-ulica').val(),
                    admin: $('#a-admin').val()
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


    }

    function editNewUser(id) {

        var err = 0;
        var tab = ['imie', 'login', 'haslo'];

        for (var tt = 0; tt < tab.length; tt++) {

            if ($('#e-' + tab[tt]).val() == '') {
                err++;
                $('#e-' + tab[tt]).css('border', '1px solid red');
            }


        }

        if (err == 0) {

            $.ajax({
                url: '../actions.php',
                data: {
                    action: 'editNewUser',
                    id: id,
                    imie: $('#e-imie').val(),
                    nazwisko: $('#e-nazwisko').val(),
                    login: $('#e-login').val(),
                    haslo: $('#e-haslo').val(),
                    miasto: $('#e-miasto').val(),
                    kraj: $('#e-kraj').val(),
                    ulica: $('#e-ulica').val(),
                    admin: $('#e-admin').val()
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


    }

    function getUser(id) {

        if (id != '') {

            $.ajax({
                url: '../actions.php',
                data: {
                    action: 'prepareeditNewUser',
                    id: id
                },
                type: 'post',

                success: function(output) {
                    if (output != 'err') {
                        $('#modalBodyEditUser').html(output);
                        $('#modalEditBtn').click();
                    }
                }
            });
        }

    }

    function delUser(id) {

        if (id != '') {

            $.ajax({
                url: '../actions.php',
                data: {
                    action: 'delUser',
                    id: id
                },
                type: 'post',

                success: function(output) {
                    if (output != 'err') {
                        location.reload(true);
                    }
                }
            });
        }

    }
</script>