$(document).ready(function() {
    $('.check-select,.form-check').click(function(e){

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

});
