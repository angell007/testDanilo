// document.location.origin + '/gestion-vehiculos' + '/gestion-vehiculos'

document.addEventListener('DOMContentLoaded', function () {

    // datatables settings
    dtClientes = $('#dataTableClientes').DataTable({

        processing: true,
        serverSide: true,
        responsive: true,
        autoWidth: false,
        stateSave: true,

        ajax: "api/clientes/",

        columns: [{
            data: 'DT_RowIndex',
            name: 'DT_RowIndex',
            orderable: false,
            searchable: false
        },
        {
            data: 'fullname',
            name: 'fullname'
        },
         {
                data: 'serie',
                render: function (data, type, row, meta) {
                    return `<img style="height: 150px" src="/img_perfiles/${row.foto}"  </img>`;
                }
        },
        {
            data: 'email',
            name: 'email'
        },
        {
            data: 'direccion',
            name: 'direccion'
        },
        {
            data: 'telefono',
            name: 'telefono'
        },
        {
            data: 'action',
            name: 'action',
            orderable: false
        },
        ],
        order: [
            [0, 'asc']
        ]

    });

});


//Envio de datos ajax
function ajaxFormRegisterCliente(event) {
    event.preventDefault();
    document.getElementById("btnSaveCliente").value = "Enviando...";

    if (document.querySelector('.is-invalid')) {

        document.querySelector('.is-invalid').classList.remove('is-invalid');

    }

    const dataRegister = new FormData(formClienteRegister);

    fetch(formClienteRegister.action, {
        method: 'POST',
        body: dataRegister,
        mode: "cors",
        headers: {
            accept: "application/json",
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })
        .then(response => {
            if (response.ok) {
                response.text().then(success => {
                    toastr.info('Success:', success);
                    dtClientes.draw();
                    document.getElementById("btnSaveCliente").value = "Enviar";
                    $('#formClienteRegister').trigger("reset");
                    $('#modalClienteRegister').modal('hide');
                });
            } else {
                throw response.json().then(error => {
                    for (var clave in error.errors) {
                        let container = formClienteRegister.elements.namedItem(clave);
                        container.classList.add('is-invalid');
                        toastr.error(`<li> ${error.errors[clave]} </li>`);
                    }

                    document.getElementById("btnSaveCliente").value = "Enviar";
                })
            }
        })
        .catch(res => {
            (console.log('request failed', res))
        });
}




//Eliminar cliente
function eliminarCliente(ente_id) {
    toastr.options.preventDuplicates = true;
    toastr.warning("<br /><button class='btn btn-sm btn-danger m-1' type='button' value='yes'>Yes</button> <button class='btn btn-sm btn-dark m-1' type ='button'  value='no' > No </button>", 'Desea eliminar este elemento ?', {
        allowHtml: true,
        onclick: function (toast) {
            value = toast.target.value
            if (value == 'yes') {
                const url = 'api/clientes/' + ente_id
                fetch(url, {
                    method: 'DELETE',
                    mode: "cors",
                    headers: {
                        accept: "application/json",
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                })
                    .then(response => {
                        if (response.ok) {
                            response.text().then(success => {
                                dtClientes.draw();
                                toastr.remove()
                                toastr.info('Success:', success);
                            });
                        }
                    })
                    .catch(error => {
                        console.log('request failed');
                    });
            } else {
                toastr.remove()
            }
        }
    });
}

// Traer datos de cliente
function editarCliente(ente_id) {
    const url = 'api/clientes/' + ente_id + '/edit'
    const formClienteUpdate = document.getElementById('formClienteUpdate');
    fetch(url, {
        method: 'GET',
        mode: "cors",
        headers: {
            accept: "application/json",
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })
        .then(response => {
            if (response.ok) {
                response.json().then(success => {
                    formClienteUpdate.id.value = success.id;
                    formClienteUpdate.nombre.value = success.nombre;
                    formClienteUpdate.apellidos.value = success.apellidos;
                    formClienteUpdate.email.value = success.email;
                    formClienteUpdate.direccion.value = success.direccion;
                    formClienteUpdate.telefono.value = success.telefono;
                    $('#modalClienteUpdate').modal('show')
                });
            }
        })
        .catch(error => {
            console.log('request failed');
        });
};

//Envio de datos ajax a actualizar
function ajaxFormUpdateCliente(event) {
    event.preventDefault();

    const dataUpdate = new FormData(formClienteUpdate);
    document.getElementById("btnUpdateCliente").value = "Enviando...";

    if (document.querySelector('.is-invalid')) {

        document.querySelector('.is-invalid').classList.remove('is-invalid');

    }

    fetch(formClienteUpdate.action, {
        method: 'POST',
        body: dataUpdate,
        mode: "cors",
        headers: {
            accept: "application/json",
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })
        .then(response => {
            if (response.ok) {
                response.text().then(success => {
                    toastr.info('Success:', success);
                    dtClientes.draw();
                    $('#formClienteUpdate').trigger("reset");
                    $('#modalClienteUpdate').modal('hide');
                    document.getElementById("btnUpdateCliente").value = "Enviar";
                });
            } else {
                throw response.json().then(error => {
                    for (var clave in error.errors) {
                        let container = formClienteUpdate.elements.namedItem(clave);
                        container.classList.add('is-invalid');
                        toastr.error(`<li> ${error.errors[clave]} </li>`);
                    }

                    document.getElementById("btnUpdateCliente").value = "Enviar";
                })
            }
        })
        .catch(error => {
            console.log('request failed');
        });
}

function verViajes(id) {
    window.location.href = '/cliente/viajes/' + id
}
