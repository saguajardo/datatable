<?php

use Saguajardo\Datatable\Datatable;

if (!function_exists('datatable')) {

    function datatable(Datatable $datatable, array $options = [])
    {
        return $datatable->renderDatatable($options);
    }

}
