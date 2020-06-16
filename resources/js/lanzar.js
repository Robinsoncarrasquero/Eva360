$(document).ready(function(){

    $('btn-update-chk').click(function(e){

        e.preventDefault();

        if (!confirm('Estas seguro de seguir')){
            return false;
        }

        var row= $(this).parents('tr');
        var form = $(this).parents('form');
        var url= form.attr('action');

        $post($url,form.serialize(), function(result){

        row.fadeOut();

        // $('#producto-total').html(result.total);

        $('#alert').html(result.message);

        }).fail(function(){

            $('#alert').html('algo salio mal');

        });

    });

});
