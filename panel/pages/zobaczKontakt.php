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

$db = new Database();
$conn = $db->connect();

$mess = new Messages();

$kontakt = $mess->getWiadomoscById($conn, $_REQUEST['id']);

$kanal = $kontakt[0]['kanal'];
$ses = $kontakt[0]['sesja_id'];


if ($kanal == "EMAIL") {
  header('Location: https://poczta.interia.pl');
  exit(0);
} else if ($kanal == "CHAT") {
} else if ($kanal == "FORMULARZ") {
} else {
  header('Location: main.php');
  exit(0);
}

?>

<style>
  #custom-search-input {
    background: #e8e6e7 none repeat scroll 0 0;
    margin: 0;
    padding: 10px;
  }

  #custom-search-input .search-query {
    background: #fff none repeat scroll 0 0 !important;
    border-radius: 4px;
    height: 33px;
    margin-bottom: 0;
    padding-left: 7px;
    padding-right: 7px;
  }

  #custom-search-input button {
    background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
    border: 0 none;
    border-radius: 3px;
    color: #666666;
    left: auto;
    margin-bottom: 0;
    margin-top: 7px;
    padding: 2px 5px;
    position: absolute;
    right: 0;
    z-index: 9999;
  }

  .search-query:focus+button {
    z-index: 3;
  }

  .all_conversation button {
    background: #f5f3f3 none repeat scroll 0 0;
    border: 1px solid #dddddd;
    height: 38px;
    text-align: left;
    width: 100%;
  }

  .all_conversation i {
    background: #e9e7e8 none repeat scroll 0 0;
    border-radius: 100px;
    color: #636363;
    font-size: 17px;
    height: 30px;
    line-height: 30px;
    text-align: center;
    width: 30px;
  }

  .all_conversation .caret {
    bottom: 0;
    margin: auto;
    position: absolute;
    right: 15px;
    top: 0;
  }

  .all_conversation .dropdown-menu {
    background: #f5f3f3 none repeat scroll 0 0;
    border-radius: 0;
    margin-top: 0;
    padding: 0;
    width: 100%;
  }

  .all_conversation ul li {
    border-bottom: 1px solid #dddddd;
    line-height: normal;
    width: 100%;
  }

  .all_conversation ul li a:hover {
    background: #dddddd none repeat scroll 0 0;
    color: #333;
  }

  .all_conversation ul li a {
    color: #333;
    line-height: 30px;
    padding: 3px 20px;
  }

  .member_list .chat-body {
    margin-left: 47px;
    margin-top: 0;
  }

  .top_nav {
    overflow: visible;
  }

  .member_list .contact_sec {
    margin-top: 3px;
  }

  .member_list li {
    padding: 6px;
  }

  .member_list ul {
    border: 1px solid #dddddd;
  }

  .chat-img img {
    height: 34px;
    width: 34px;
  }

  .member_list li {
    border-bottom: 1px solid #dddddd;
    padding: 6px;
  }

  .member_list li:last-child {
    border-bottom: none;
  }

  .member_list {
    height: 380px;
    overflow-x: hidden;
    overflow-y: auto;
  }

  .sub_menu_ {
    background: #e8e6e7 none repeat scroll 0 0;
    left: 100%;
    max-width: 233px;
    position: absolute;
    width: 100%;
  }

  .sub_menu_ {
    background: #f5f3f3 none repeat scroll 0 0;
    border: 1px solid rgba(0, 0, 0, 0.15);
    display: none;
    left: 100%;
    margin-left: 0;
    max-width: 233px;
    position: absolute;
    top: 0;
    width: 100%;
  }

  .all_conversation ul li:hover .sub_menu_ {
    display: block;
  }

  .new_message_head button {
    background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
    border: medium none;
  }

  .new_message_head {
    background: #f5f3f3 none repeat scroll 0 0;
    float: left;
    font-size: 13px;
    font-weight: 600;
    padding: 18px 10px;
    width: 100%;
  }

  .message_section {
    border: 1px solid #dddddd;
  }

  .chat_area {
    float: left;
    height: 300px;
    overflow-x: hidden;
    overflow-y: auto;
    width: 100%;
  }

  .chat_area li {
    padding: 14px 14px 0;
  }

  .chat_area li .chat-img1 img {
    height: 40px;
    width: 40px;
  }

  .chat_area .chat-body1 {
    margin-left: 50px;
  }

  .chat-body1 p {
    background: #fbf9fa none repeat scroll 0 0;
    padding: 10px;
  }

  .chat_area .admin_chat .chat-body1 {
    margin-left: 0;
    margin-right: 50px;
  }

  .chat_area li:last-child {
    padding-bottom: 10px;
  }

  .message_write {
    background: #f5f3f3 none repeat scroll 0 0;
    float: left;
    padding: 15px;
    width: 100%;
  }

  .message_write textarea.form-control {
    height: 70px;
    padding: 10px;
  }

  .chat_bottom {
    float: left;
    margin-top: 13px;
    width: 100%;
  }

  .upload_btn {
    color: #777777;
  }

  .sub_menu_>li a,
  .sub_menu_>li {
    float: left;
    width: 100%;
  }

  .member_list li:hover {
    background: #428bca none repeat scroll 0 0;
    color: #fff;
    cursor: pointer;
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
                <h5 class="card-title mb-5">Szczegóły #<?php echo $_REQUEST['id']; ?></h5>
              </div>
              <div class="col-6">
                <div class="d-flex justify-content-end">
                </div>
              </div>

            </div>

            <?php
            if ($kanal == "CHAT") {
              $messes = $mess->getMessegesBySession($conn, $ses);


            ?>

              <div class="col-sm-12 message_section">
                <div class="row">
                  <div class="new_message_head">
                    <div class="pull-left"><button><i class="fa fa-plus-square-o" aria-hidden="true"></i> Wiadomość CHAT</button></div>
                  </div>

                  <div class="chat_area">

                    <ul class="list-unstyled" id="adminChat-<?php echo $ses; ?>">

                      <?php
                      if (is_array($messes) && !empty($messes)) {
                        $ileMesses = count($messes);

                        if ($ileMesses > 0) {
                          for ($tt = 0; $tt < $ileMesses; $tt++) {
                            $zdjecie = ($messes[$tt]['zdjecie'] != '') ? $messes[$tt]['zdjecie'] : "img/default.png";
                            $imie = ($messes[$tt]['imie'] != '') ? $messes[$tt]['imie'] : $messes[$tt]['sesja_id'];
                      ?>

                            <li class="left clearfix">
                              <span class="chat-img1 pull-left">
                                <img src="../<?php echo $zdjecie; ?>" alt="Avatar" class="img-circle">
                                <?php echo $imie; ?>
                              </span>
                              <div class="chat-body1 clearfix">
                                <p><?php echo $messes[$tt]['wiadomosc']; ?></p>
                                <div class="chat_time pull-right"><?php echo $messes[$tt]['data_add']; ?></div>
                              </div>
                            </li>
                      <?php
                          }
                        }
                      }
                      ?>


                    </ul>
                  </div>
                  <div class="message_write">
                    <textarea class="form-control" id="adminMessage" placeholder="Napisz wiadomość"></textarea>
                    <div class="clearfix"></div>
                    <div class="chat_bottom  d-flex justify-content-end">
                      <button class="btn btn-success mr-3" onclick="location.reload(true);">Odswież</button>
                      <button class="btn btn-primary" onclick="sendMessageAdmin('<?php echo $ses; ?>')">Wyślij wiadomość</button>
                    </div>
                  </div>
                </div>
              </div>
            <?php
            } else if ($kanal == "FORMULARZ") {
            ?>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Imię</label>
                    <input type="text" class="form-control" value="<?php echo $kontakt[0]['imie']; ?>" placeholder="Imię" disabled>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" value="<?php echo $kontakt[0]['email']; ?>" placeholder="Email" disabled>
                  </div>
                </div>
                <div class="col-md-12 mt-3">
                  <div class="form-group">
                    <label>Temat</label>
                    <input type="text" class="form-control" value="<?php echo $kontakt[0]['temat']; ?>" placeholder="Temat" disabled>
                  </div>
                </div>
                <div class="col-md-12 mt-3">
                  <div class="form-group">
                    <label>Wiadomość</label>
                    <textarea disabled class="form-control" cols="30" rows="7" placeholder="Wiadomość"><?php echo $kontakt[0]['wiadomosc']; ?></textarea>
                  </div>
                </div>
                <div class="col-md-12 mt-4">
                  <div class="form-group d-flex justify-content-end">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#modalOdpMail"><i class="fa fa-envelope"></i> Odpowiedz </button>
                  </div>
                </div>
              </div>




            <?php
            }
            ?>


          </div>
        </div>
      </div>
      <!-- /.col-md-6 -->
    </div>
  </div>
</div>

<!-- Modal PRZYDZIELENIE NAPISZ MAILA -->
<div class="modal fade" id="modalOdpMail" tabindex="-1" role="dialog" aria-labelledby="modalOdpMail" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalOdpMail">Odpowiedź na formularz</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modalOdpMailBody">
        <div class="form-group">
          <label for="email">Email:</label>
          <input type="email" class="form-control" value="<?php echo $kontakt[0]['email']; ?>" id="odp-email" placeholder="Enter email">
        </div>
        <div class="form-group">
          <label>Wiadomość:</label>
          <textarea class="form-control" id="odp-wiadomosc" rows="3"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
        <button type="button" class="btn btn-success" onclick="WyslijOdpMail()"> Wyślij </button>
      </div>
    </div>
  </div>
</div>


</div>






<?php
include('../footer.php');
?>

<script>
  function WyslijOdpMail() {


    var email = $('#odp-email');
    var wiadomosc = $('#odp-wiadomosc');

    if (email.val() != '') {
      if (wiadomosc.val() != '') {

        $.ajax({
          url: '../actions.php',
          data: {
            action: 'WyslijOdpMail',
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

  function sendMessageAdmin(sesja) {

    var mess = $('#adminMessage').val();
    var sesja = <?php echo json_encode($ses); ?>

    if (mess != '' && sesja != '') {

      $.ajax({
        url: '../actions.php',
        data: {
          action: 'sendAdminMessage',
          message: mess,
          sesja: sesja
        },

        type: 'post',

        success: function(output) {
          if (output != 'err') {
            $('#adminChat-' + sesja).append(output);
            $('#adminMessage').val('');
          }
        }
      });


    }



  }
</script>