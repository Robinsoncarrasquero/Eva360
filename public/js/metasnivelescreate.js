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

        var input0 =$("<input/>",{
            type: "text",
            name: "submetaid[]",
            placeholder: "Submeta id "
        });
        var td0=$('<td/>');
        td0.append(input0);

        var input1 =$("<input/>",{
            type: "text",
            name: "submetaName[]",
            maxlength:1,
            placeholder: "Submeta "
        });
        var td1=$('<td/>');
        td1.append(input1);

        var input2 =$("<textarea/>",{
            name: "submetaDescription[]",
            rows:1,cols:50,
            maxlength:100,
            placeholder: "Describa la pregunta"
        });
        var td2=$('<td/>');
        td2.append(input2);

        var input3=$("<input/>",{
            type: "text",
            name: "submetaValorMeta[]",
            value:'0',
            maxlength:100,
            placeholder: "Valor de 0 al 100"
        });
        var td3=$('<td/>');
        td3.append(input3);

        var input4=$("<input/>",{
            type: "text",
            name: "submetaPeso[]",
            value:'0',
            maxlength:100,
            placeholder: "Peso de 0 al 100"
        });
        var td4=$('<td/>');
        td4.append(input4);

        var btn =$("<button/>",{
            type: "button",
            class: "btnquitar btn btn-danger"
        });

        var icon =$("<i/>",{
            class:"material-icons btn-block",
            text: "delete"
        });
        btn.append(icon);
        var td5=$('<td/>').append(btn);
        var tr=$('<tr/>',{
        });

        tr.append(td0);
        tr.append(td1);
        tr.append(td2);
        tr.append(td3);
        tr.append(td4);
        tr.append(td5);
        $('#tablepreguntas tbody').append(tr);

    })


});
