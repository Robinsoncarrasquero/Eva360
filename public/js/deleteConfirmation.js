function deleteConfirmation(id,route) {

    swal({
        title: "Borrar?",
        text: "Por favor asegurate y entonces confirma!",
        type: "warning",
        showCancelButton: !0,
        confirmButtonText: "Si, eliminar esto!",
        cancelButtonText: "No, cancelar!",
        reverseButtons: !0
    }).then(function (e) {
        if (e.value === true) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: 'POST',
                data: {_token: CSRF_TOKEN},
                url:route,
                dataType: 'JSON',
                success: function (results) {
                    // if (results.success === true) {
                    //     document.getElementById(id).remove();
                    //     swal("Done!", results.message + id, "success");
                    // } else {
                    //     swal("Error!", results.message, "error");
                    // }
                    let row= $(this).parents('tr');
                    row.remove();
                }
            });
        } else {
            e.dismiss;
        }
    }, function (dismiss) {
        return false;
    })
}
