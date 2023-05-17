<!-- Stopka -->
<footer class="py-5 bg-dark">
    <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; Sklep internetowy 2023</p>
    </div>
</footer>
<!-- jQuery -->
<script src="../panel/admin/plugins/jquery/jquery.js"></script>
<!-- Bootstrap -->
<script src="../panel/admin/plugins/bootstrap/js/bootstrap.js"></script>
<!-- Własne skrypty -->
<script src="../panel/admin/dist/js/adminlte.min.js"></script>
<script src="js/skrypty.js"></script>

<script>
    function sendMessage() {

        var mess = $('#chatMessage').val();
        var sesja = <?php echo json_encode(session_id()); ?>


        if (mess != '' && sesja != '') {

            $.ajax({
                url: 'akcje.php',
                data: {
                    action: 'sendMessage',
                    message: mess,
                    sesja: sesja
                },

                type: 'post',

                success: function(output) {
                    if (output != 'err') {
                        $('#chat-'+sesja).append(output);
                        $('#chatMessage').val('');
                        
                    }
                }
            });


        }

    }


    function getChatMessenges() 
    {

        var sesja = <?php echo json_encode(session_id()); ?>

        if (sesja != '') {


            $.ajax({
                url: 'akcje.php',
                data: {
                    action: 'getChatMessenges',
                    sesja: sesja
                },

                type: 'post',

                success: function(output) {
                    if (output != 'err') {
                        $('#chat-'+sesja).append(output);
                        $('#countMesseges').text(parseInt($('#countMesseges').text(), 10) + 1);
                    }
                }
            });


        } 

    }

    setInterval(getChatMessenges, 3000);


    function koszyk(id, todo) {


        if (id != '') {

            var sesja = <?php echo json_encode($token) ?>;

            $.ajax({
                url: 'akcje.php',
                data: {
                    action: 'koszyk',
                    todo: todo, // 2 - dodanie, 1 - usuniecie
                    sesja: sesja,
                    produkt_id: id
                },

                type: 'post',

                success: function(output) {
                    if (output == 1) {
                        if (todo == 2) {
                            $('#buttonModalShow').click();
                        } else {
                            window.location.reload(true);
                        }

                    } else {
                        alert(output);
                    }
                }
            });

        }
    }
</script>