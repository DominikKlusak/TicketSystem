$(document).ready(function () {

    $('#tabZam thead tr')
            .clone(true)
            .addClass('filters')
            .appendTo('#tabZam thead');

    $('#tabZam').DataTable({
        
        orderCellsTop: true,
        fixedHeader: true,
        initComplete: function () {
            var api = this.api();

            api
                    .columns([0, 1, 2, 3, 4,5])
                    .eq(0)
                    .each(function (colIdx) {
                       
                        var cell = $('.filters th').eq(
                                $(api.column(colIdx).header()).index()
                                );
                        var title = $(cell).text();
                        $(cell).html('<input type="text" class="form-control" placeholder="' + title + '" />');

                        $(
                                'input',
                                $('.filters th').eq($(api.column(colIdx).header()).index())
                                )
                                .off('keyup change')
                                .on('keyup change', function (e) {
                                    e.stopPropagation();
                                
                                    $(this).attr('title', $(this).val());
                                    var regexr = '({search})'; 

                                    var cursorPosition = this.selectionStart;
                                    api
                                            .column(colIdx)
                                            .search(
                                                    this.value != ''
                                                    ? regexr.replace('{search}', '(((' + this.value + ')))')
                                                    : '',
                                                    this.value != '',
                                                    this.value == ''
                                                    )
                                            .draw();

                                    $(this)
                                            .focus()[0]
                                            .setSelectionRange(cursorPosition, cursorPosition);
                                });
                    });
        },

        "paging": true,

        "lengthChange": true,

        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Wszystko"]],
        
        "pageLength": 100,

        "searching": true,

        "ordering": true,

        "info": true,

        "autoWidth": true,

        "responsive": false,

        "language": {

            "processing": "Przetwarzanie...",

            "search": "Szukaj:",

            "lengthMenu": "Pokaż _MENU_ pozycji",

            "info": "Pozycje od _START_ do _END_ z _TOTAL_ łącznie",

            "infoEmpty": "Pozycji 0 z 0 dostępnych",

            "infoFiltered": "(filtrowanie spośród _MAX_ dostępnych pozycji)",

            "infoPostFix": "",

            "loadingRecords": "Wczytywanie...",

            "zeroRecords": "Nie znaleziono pasujących pozycji",

            "emptyTable": "Brak danych",

            "paginate": {

                "first": "Pierwsza",

                "previous": "Poprzednia",

                "next": "Następna",

                "last": "Ostatnia"

            },

            "aria": {

                "sortAscending": ": aktywuj, by posortować kolumnę rosnąco",

                "sortDescending": ": aktywuj, by posortować kolumnę malejąco"

            },

        }



    });


   


});


$(document).ready(function () {

    $('#tabWiad thead tr')
            .clone(true)
            .addClass('filters')
            .appendTo('#tabWiad thead');

    $('#tabWiad').DataTable({
        
        orderCellsTop: true,
        fixedHeader: true,
        initComplete: function () {
            var api = this.api();

            api
                    .columns([0, 1, 2, 3, 4])
                    .eq(0)
                    .each(function (colIdx) {
                       
                        var cell = $('.filters th').eq(
                                $(api.column(colIdx).header()).index()
                                );
                        var title = $(cell).text();
                        $(cell).html('<input type="text" class="form-control" placeholder="' + title + '" />');

                        $(
                                'input',
                                $('.filters th').eq($(api.column(colIdx).header()).index())
                                )
                                .off('keyup change')
                                .on('keyup change', function (e) {
                                    e.stopPropagation();
                                
                                    $(this).attr('title', $(this).val());
                                    var regexr = '({search})'; 

                                    var cursorPosition = this.selectionStart;
                                    api
                                            .column(colIdx)
                                            .search(
                                                    this.value != ''
                                                    ? regexr.replace('{search}', '(((' + this.value + ')))')
                                                    : '',
                                                    this.value != '',
                                                    this.value == ''
                                                    )
                                            .draw();

                                    $(this)
                                            .focus()[0]
                                            .setSelectionRange(cursorPosition, cursorPosition);
                                });
                    });
        },

        "paging": true,

        "lengthChange": true,

        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Wszystko"]],
        
        "pageLength": 100,

        "searching": true,

        "ordering": true,

        "order": [0, "desc"],

        "info": true,

        "autoWidth": true,

        "responsive": false,

        "language": {

            "processing": "Przetwarzanie...",

            "search": "Szukaj:",

            "lengthMenu": "Pokaż _MENU_ pozycji",

            "info": "Pozycje od _START_ do _END_ z _TOTAL_ łącznie",

            "infoEmpty": "Pozycji 0 z 0 dostępnych",

            "infoFiltered": "(filtrowanie spośród _MAX_ dostępnych pozycji)",

            "infoPostFix": "",

            "loadingRecords": "Wczytywanie...",

            "zeroRecords": "Nie znaleziono pasujących pozycji",

            "emptyTable": "Brak danych",

            "paginate": {

                "first": "Pierwsza",

                "previous": "Poprzednia",

                "next": "Następna",

                "last": "Ostatnia"

            },

            "aria": {

                "sortAscending": ": aktywuj, by posortować kolumnę rosnąco",

                "sortDescending": ": aktywuj, by posortować kolumnę malejąco"

            },

        }



    });


   


});



$(document).ready(function () {

    $('#tabUsers thead tr')
            .clone(true)
            .addClass('filters')
            .appendTo('#tabUsers thead');

    $('#tabUsers').DataTable({
        
        orderCellsTop: true,
        fixedHeader: true,
        initComplete: function () {
            var api = this.api();

            api
                    .columns([0, 1, 2, 3, 4, 5])
                    .eq(0)
                    .each(function (colIdx) {
                       
                        var cell = $('.filters th').eq(
                                $(api.column(colIdx).header()).index()
                                );
                        var title = $(cell).text();
                        $(cell).html('<input type="text" class="form-control" placeholder="' + title + '" />');

                        $(
                                'input',
                                $('.filters th').eq($(api.column(colIdx).header()).index())
                                )
                                .off('keyup change')
                                .on('keyup change', function (e) {
                                    e.stopPropagation();
                                
                                    $(this).attr('title', $(this).val());
                                    var regexr = '({search})'; 

                                    var cursorPosition = this.selectionStart;
                                    api
                                            .column(colIdx)
                                            .search(
                                                    this.value != ''
                                                    ? regexr.replace('{search}', '(((' + this.value + ')))')
                                                    : '',
                                                    this.value != '',
                                                    this.value == ''
                                                    )
                                            .draw();

                                    $(this)
                                            .focus()[0]
                                            .setSelectionRange(cursorPosition, cursorPosition);
                                });
                    });
        },

        "paging": true,

        "lengthChange": true,

        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Wszystko"]],
        
        "pageLength": 100,

        "searching": true,

        "ordering": true,

        "info": true,

        "autoWidth": true,

        "responsive": false,

        "language": {

            "processing": "Przetwarzanie...",

            "search": "Szukaj:",

            "lengthMenu": "Pokaż _MENU_ pozycji",

            "info": "Pozycje od _START_ do _END_ z _TOTAL_ łącznie",

            "infoEmpty": "Pozycji 0 z 0 dostępnych",

            "infoFiltered": "(filtrowanie spośród _MAX_ dostępnych pozycji)",

            "infoPostFix": "",

            "loadingRecords": "Wczytywanie...",

            "zeroRecords": "Nie znaleziono pasujących pozycji",

            "emptyTable": "Brak danych",

            "paginate": {

                "first": "Pierwsza",

                "previous": "Poprzednia",

                "next": "Następna",

                "last": "Ostatnia"

            },

            "aria": {

                "sortAscending": ": aktywuj, by posortować kolumnę rosnąco",

                "sortDescending": ": aktywuj, by posortować kolumnę malejąco"

            },

        }



    });


   


});


function changePassword(id) {

    if (id != '') {

        var arr = ['old', 'new1', 'new2'];
        var err = 0;

        for (var i = 0; i < arr.length; i++) {

            $('#nPass_'+arr[i]).css('border', '1px solid #e4e4e4');

            if ($('#nPass_'+arr[i]).val() == "") {
                $('#nPass_'+arr[i]).css('border', '1px solid red');
                $('#nPass_err').html("<span class='mb-4' style='color: red; font-weight:bold; text-align: center'> Wypełnij wymagane pola. </span>");
                err++;
            }

        }


        if (err == 0) {

            $.ajax({
                url: '../actions.php',
                    data: {
                    action: 'changePassword',
                    oldPass: $('#nPass_old').val(),
                    newPass1: $('#nPass_new1').val(),
                    newPass2: $('#nPass_new2').val(),
                    user_id: id
                },

                type: 'post',
                    
                    success: function(output) {
                        if (output == 1)
                        {
                            $('#nPass_err').html("<span class='mb-4' style='color: green; font-weight:bold; text-align: center'> Hasło zmienione. Za chwilę nastąpi wylogowanie. </span>");
                            setTimeout(function() { location.href='../index.php';}, 5000);
                            
                        } else {
                            $('#nPass_err').html("<span class='mb-4' style='color: red; font-weight:bold; text-align: center'> "+output+" </span>");
                        }
                    }
            });	


        }

    }



}
