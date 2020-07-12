$(document).ready(function () {

    $(document).on('click','.btnquitar',function(e){
        id=$(this).parents('tr').prop('id');
        var row= $(this).parents('tr');
        $(this).parents("tr").remove();
    })


    $(".xbtnponer").on('click',function (e) {

        var td1=$('<td>').append($('<input>',{ type:"text", name:"name[]", value:"Mary Bristol"}));
        var td2=$('<td>').append($('<input>',{ type:"text", name:"relation[]", value:"Other"}));
        var td3=$('<td>').append($('<input>',{ type:"email", name:"email[]", value:"mail@youdomain.com"}));
        var td4='<td><button type="button"class="btnquitar btn btn-danger"><i class="material-icons">delete</i></td>';
        var tr=$('<tr>',{
        });

        tr.append(td1);
        tr.append(td2);
        tr.append(td3);
        tr.append(td4);

        $('#tableevaluado tbody').append(tr);

        // $(document).ready(function(){
        //     $("tbody").parents().css({"color": "red", "border": "2px solid red"});
        // });

        //$('#tableevaluado').append(tr2);

        // $('#tableevaluado tbody tr').each(function() {
        //     //console.log(this.id);
        //     alert(this.id);
        // });

    })

    $(document).on('click','nada',function(){
        var col = $(this).parent().children().index($(this));
        var row = $(this).parent().parent().children().index($(this).parent());
        alert('Row: ' + row + ', Column: ' + col );
    })

    $(".btnponer").on('click',function (e) {

        var input1 =$("<input/>",{
            type: "text",
            name: "name[]",
            maxlength:100,
            placeholder: "Ingrese el Nombre del Evaluador"
        });
        var td1=$('<td/>');
        td1.append(input1);

        var input2 =$("<input/>",{
            type: "text",
            name: "relation[]",
            maxlength:10,
            placeholder: "Relacion con el evaluado (Jefe,Partner,Cliente,XYZ)"
        });
        var td2=$('<td/>');
        td2.append(input2);

        var input3=$("<input/>",{
            type: "email",
            name: "email[]",
            value:'boss@example.com',
            maxlength:100,
            placeholder: "Ingrese un email valido"
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

        $('#tableevaluado tbody').append(tr);


    })


});

