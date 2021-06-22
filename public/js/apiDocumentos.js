
document.addEventListener('DOMContentLoaded', function () {

    // datatables settings Documentos
    dtDocumento = $('#dataTableDocumentos').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        autoWidth: false,
        stateSave: true,

        ajax:  "/documentos/",

        columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                data: 'propietario.fullname',
                name: 'propietario.fullname'
            },
            {
                data: 'placa',
                name: 'placa'
            },

            {
                data: 'marca',
                name: 'marca'
            },
            {
                data: 'modelo',
                name: 'modelo'
            },

            {
                data: 'estado',
                name: 'estado'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false
            },
        ],
        order: [
            [0, 'desc']
        ]

    });

});
