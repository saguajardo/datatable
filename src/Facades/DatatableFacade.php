<?php

namespace Saguajardo\Datatable\Facades;

use Illuminate\Support\Facades\Facade;

class DatatableFacade extends Facade {

    public static function getFacadeAccessor()
    {
        return 'datatable';
    }
}
