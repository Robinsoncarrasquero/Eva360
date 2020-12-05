
//Aun no esta impmentado y viene de la vista seleccionarmodelo.blade
//Nos permite mostrar las competencias de un modelo seleccionado
$(document).on('click','.btnradio',function(e){

    id=$(this).parents('tr').prop('id');
    td='<tr><td>No hay Informacion</td></tr>';
    $.ajax({
        type:'GET',
        url:"{{ route('modelo.ajaxcompetencias') }}",
        data:{id:id},
        success:function(data){
            if (data.success){
                td='';
                var datajson=data.dataJson;
                datajson.forEach(logArrayElements);
            }
            $("#tbody-table-seleccionado").html(td);
        }

    });

    function logArrayElements(element, index, array) {
        td +="<tr><td>"+element+"</td></tr>";
        console.log("a[" + index + "] = " + element);
    }

});


