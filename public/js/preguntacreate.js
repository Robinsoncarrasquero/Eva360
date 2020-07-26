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

    $(".btnponer").on('click',function (e) {
        var input1 =$("<input/>",{
            type: "text",
            name: "gradoName[]",
            maxlength:1,
            placeholder: "Grado "
        });
        var td1=$('<td/>');
        td1.append(input1);

        var input2 =$("<textarea/>",{
            name: "gradoDescription[]",
            rows:4,cols:50,
            maxlength:1000,
            placeholder: "Describa la pregunta"
        });
        var td2=$('<td/>');
        td2.append(input2);

        var input3=$("<input/>",{
            type: "text",
            name: "gradoPonderacion[]",
            value:'0',
            maxlength:100,
            placeholder: "Poderacion de 0 al 100"
        });
        var td3=$('<td/>');
        td3.append(input3);

        var btn =$("<button/>",{
            type: "button",
            class: "btnquitar btn btn-danger"
        });
        var icon =$("<i/>",{
            class:"material-icons btn-block",
            text: "delete"
        });
        btn.append(icon);
        var td4=$('<td/>').append(btn);
        var tr=$('<tr/>',{
        });

        tr.append(td1);
        tr.append(td2);
        tr.append(td3);
        tr.append(td4);

        $('#tablepreguntas tbody').append(tr);

    })


});
