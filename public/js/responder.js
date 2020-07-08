$(document).ready(function() {
    $('.check-select,.form-check').click(function(e){

        //e.preventDefault();

        var row = $(this).parents('tr');
        var id=row.data('id');
        var divtodo= document.getElementById('divtodo');
        // for(i=0;i<row.length;i++)
        //     // if(chkAsientos[i].checked)
        //     //     asientos.push(chkAsientos[i].value);
        //     divtodo.innerHTML = "<b>Tus tr:</b> ";

        // }

        $(".filas").each(function(){
            var xrow = $(this).attr('data-id');
            if (id!=xrow){
               $(this).remove();
            }

        });


        // var form = $('#form-select');
        // var attrAccion =form.attr('action');
        // var url = attrAccion.replace(':ID-COMPETENCIA',id)

        // var data = form.serialize();


        // $.post(url,data,function(result){
        //     alert(result);
        // });
        // $.ajax({
        //     type: "POST",
        //     url:url,
        //     data:data,
        //     success: function (data) {
        //         alert(data);
        //     },
        //     error: function (data) {
        //         console.log('Error:', data);
        //     }
        // });


    });

});
