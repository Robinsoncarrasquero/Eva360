function deleteConfirmationSubItem(id,route) {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    //e.preventDefault();
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
                dataid=$(this).parents('tr').prop('id');
                let row= $(this).parents('tr');
                row.remove();

        }
    });

}

