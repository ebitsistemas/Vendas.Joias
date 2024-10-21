$(document).on('click', '.newCart', function () {
    Swal.fire({
        title: 'Você tem certeza que deseja remover este registro?',
        text: "Se você escolher SIM, o registro será deletado para sempre.",
        icon: "warning",
        buttonsStyling: false,
        showCancelButton: true,
        confirmButtonText: '<i class="fa fa-check-circle"></i> Sim',
        cancelButtonText: '<i class="fa fa-times-circle"></i> Não',
        customClass: {
            actions: 'my-actions',
            confirmButton: 'btn btn-success mr-3',
            cancelButton: 'btn btn-danger',
        }
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: '/financeiro/formas_pagamento/' + id,
                dataType: 'json',
                type: "POST",
                data: {
                    _token: $("input[name=_token]").val(),
                    _method: 'DELETE'
                },
                success: function (data) {
                    if (data.success) {
                        table.ajax.reload();
                        toastr.success(data.msg, 'Formas de Pagamento');
                    } else {
                        toastr.error(data.msg, 'Formas de Pagamento');
                    }
                },
                error: function (data) {
                    toastr.error(data.responseJSON.msg ?? data.responseJSON.message, 'Formas de Pagamento');
                }
            });
        }
    });
})
