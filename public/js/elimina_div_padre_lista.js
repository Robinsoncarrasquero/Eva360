$(document).ready(function() {
    $('.radiofrecuencia').click(function(e){
        var padre_id= $(this).attr('data-id');
        $(".filas").each(function(){
            var row_id = $(this).attr('id');
            console.log(row_id);
            if (padre_id!=row_id){
                $(this).remove();
            }
        });

    });
});
