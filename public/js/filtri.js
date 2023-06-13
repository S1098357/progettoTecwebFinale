
$(function() {
    function ricercaFiltribyNameAndWords() {
        $('#ricercaParola').on('keyup', function() {
            var $value1 = $('#ricercaAzienda').val();
            var $value2 = $(this).val();
            if ($value1 || $value2) {
                $('#all-data').hide();
                $('#searched-content').show();
            } else {
                $('#all-data').show();
                $('#searched-content').hide();
            }
            // metter fuori la route ajax per compattare tutto in una volta
            $.ajax({
                type: 'GET',
                url: './listaPromozioni/filtered',
                data: {'ricercaParola': $value2, 'ricercaAzienda': $value1},
                success: function(data) {
                    console.log(data);
                    $('#searched-content').html(data);
                }
            });
        });

        $('#ricercaAzienda').on('keyup', function() {
            var $value1 = $(this).val();
            var $value2 = $('#ricercaParola').val();
            if ($value1 || $value2) {
                $('#all-data').hide();
                $('#searched-content').show();
            } else {
                $('#all-data').show();
                $('#searched-content').hide();
            }
            $.ajax({
                type: 'GET',
                url: './listaPromozioni/filtered',
                data: {'ricercaParola': $value2, 'ricercaAzienda': $value1},
                success: function(data) {
                    console.log(data);
                    $('#searched-content').html(data);
                }
            });
        });
    }

    ricercaFiltribyNameAndWords();
});





$(function aperturaFiltri() {
    $('#filter-button').click(function () {
        $('#filtri').slideToggle();
    })
})

$(function chiusuraFiltri() {
    $('#close-button').click(function () {
        $('#filtri').slideToggle();
    })
})

function redirectToRoute(route) {
    window.location.href = route;
}
