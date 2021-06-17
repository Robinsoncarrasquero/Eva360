$(document).ready(function() {

    $('.check-select').click(function(e){
        var row = $(this).parents('tr');
        var id=row.data('id');
        var divtodo= document.getElementById('divtodo');
        $(".filas").each(function(){
            var xrow = $(this).attr('data-id');
            if (id!=xrow){
               $(this).remove();
            }
        });


    });


    $('.radiofrecuencia').click(function(e){
        var row = $(this).parents('tr');
        var id=row.data('id');
        $(".filas").each(function(){
            var xrow = $(this).attr('data-id');
            if (id!=xrow){
                $(this).remove();
            }

        });

    });

    $('.no-radiofrecuencia').click(function(e){
        var row = $(this).parents('tr');
        var id=row.data('id');

        $(".filas").each(function(){
            var xrow = $(this).attr('data-id');
            // if (id!=xrow){
            //     $(this).remove();
            // }
        });
        if (!$("#radiogrado"+id).is(':checked')){
            $("#radiogrado"+id).prop('checked',true);
        }

    });

    $('.no-check-select').click(function(e){
        var row = $(this).parents('tr');
        var id=row.data('id');
        var divtodo= document.getElementById('divtodo');
        $(".filas").each(function(){
            var xrow = $(this).attr('data-id');
            // if (id!=xrow){
            //    $(this).remove();
            // }
        });

    });

});
