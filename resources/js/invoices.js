$(function(){

    var fechaActual = new Date();
    var datetime = "Creado el: " + fechaActual.getDate() + "/"
        + (fechaActual.getMonth()+1)  + "/"
        + fechaActual.getFullYear() + " a las " 
        + fechaActual.getHours() + ":" 
        + fechaActual.getMinutes() + ":"
        + fechaActual.getSeconds();

    $('#invoicesTable tfoot th').each(function () {
        //Apply the search except to the last column
        if ($(this).index() < $('#invoicesTable tfoot th').length - 1) {
            var title = $(this).text();
            $(this).html('<input class="form-control form-control-sm" type="text" placeholder="Buscar ' + title + '" />');
        }else{
            $(this).html('');
        }
    });

    var proyectosTable = $('#invoicesTable').DataTable({
        initComplete: function () {
            this.api().columns().every(function () {
                var that = this;
                $('input', this.footer()).on('keyup change clear', function () {
                    if (that.search() !== this.value) {
                        that.search(this.value).draw();
                    }
                });
            });
        },
        "language": {
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "zeroRecords": "No se encontraron resultados",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(filtrado de _MAX_ registros totales)",
            "search": "Buscar:",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            }
        },
        dom: '<"container-fluid"<"row"<"col"l><"col"B><"col"f>>>rtip',
        buttons: [
            {
                extend: 'print',
                text: 'Imprimir esta tabla',
                title: 'Reporte de Documentos Emitidos',
            },
        ],
        "order": [[ 0, "desc" ]],
    });
})

$(".btn-modal").on("click", function (e) {
    var button = $(e.target);
    var codGeneracion = button.data('id');
    console.log(codGeneracion);
    $('#codGeneracion').val(codGeneracion);
});