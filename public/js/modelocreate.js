
$(document).ready(function () {

    $(document).on('click','.btnquitar',function(e){
        id=$(this).parents('tr').prop('id');
        var row= $(this).parents('tr');
        $(this).parents("tr").remove();
    })

    $(document).on('click','nada',function(){
        var col = $(this).parent().children().index($(this));
        var row = $(this).parent().parent().children().index($(this).parent());
        alert('Row: ' + row + ', Column: ' + col );
    })

    $(document).on('click','.btncheck',function(e){

        if($(this).is(':checked',true)){
            id=$(this).parents('tr').prop('id');
            var row= $(this).parents('tr');
            var f=null;
            f=$(this).closest('tr').clone(false)
            $('#table2 tbody').append(f);
            $(this).parents("tr").remove();
            return;
        }else{
            id=$(this).parents('tr').prop('id');
            var row= $(this).parents('tr');
            var f=null;
            f=$(this).closest('tr').clone(false)
            $('#table1 tbody').append(f);
            $(this).parents("tr").remove();
            return;
        }
    })

});

