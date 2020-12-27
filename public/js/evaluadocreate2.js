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
        e.preventDefault();
        var nFilas = $("#table-evaluado tr").length -1 ;

        var td0 =$("<td/>",{
            class:"form-control",
        });
        td0.append('*');

        var input1 =$("<input/>",{
            type: "text",
            name: "name[]",
            maxlength:100,
            placeholder: "Nombre del evaluador"
        });
        var td1=$('<td/>');
        td1.append(input1);

        var input2 =$("<input/>",{
            type: "text",
            name: "relation[]",
            maxlength:15,
            placeholder: "Relacion con el evaluado",
            value: "Par"
        });
        var td2=$('<td/>');
        td2.append(input2);

        // var input2 =$("<select/>",{
        //      type:"option",
        //      name: "relation[]",
        //      value="Par"
        //  });
        // <option selected value="Autoevaluacion">Autoevaluacion</option>

        // var td2=$('<td/>');
        // td2.append(input2);

        var input3=$("<input/>",{
            type: "email",
            name: "email[]",
            value:'email@example.com',
            maxlength:100,
            placeholder: "Email"
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

        tr.append(td0);
        tr.append(td1);
        tr.append(td2);
        tr.append(td3);
        tr.append(td4);

        $('#table-evaluado tbody').append(tr);

    })


});

