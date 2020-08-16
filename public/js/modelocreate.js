
$(document).ready(function () {

    $(document).on('click','.btncheck',function(e){
        if ($('#name').val()==''){
            e.preventDefault();
            return;
        }
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

