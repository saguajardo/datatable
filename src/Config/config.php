<?php

return [
    // Styles
    'class'             => 'table table-striped table-bordered table-hover',
    'options'           => 'cellspacing="0" width="99%"',

    // Templates
    'table_template'             => 'datatable::table',
    'script_template'            => 'datatable::script',
    'default_template'            => 'datatable::default',

    // Functions
    'functions'         => [
                "oLanguage" => '{
                    "sSearch": "Filtrar:",
                    "sLoadingRecords": \'<div><div class="row row-centered"><img width="30px" height="30px" src="../bootstrap/dist/images/loading_upload.gif" alt="cargando"></div></div>\',
                },',
    ],

    // Datatable's Default values
    'defaults' => [
        "searching" => "true",
        "ordering" => "true",
        "dom" => "\"<'row'<'col-sm-6'l><'col-sm-6'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-5'i><'col-sm-7'p>>\"",
        "language" => '{
                "zeroRecords": "No hay coincidencias",
                "emptyTable": "No se encuentran registros",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                "lengthMenu": "Mostrar _MENU_ registros",
                "infoEmpty": "Mostrando 0 a 0 de 0 registros",
                "infoFiltered": "(filtrado en un total de _MAX_ registros)",
                "loadingRecords": "<div align=\'center\'><div id=\'imgLoadingDT\'><i class=\'fa fa-refresh fa-spin\'></i></div></div>",
                "paginate": {
                    "first": "<<",
                    "last": ">>",
                    "previous": "<",
                    "next": ">"
                }
            }',
    ],
    

];
