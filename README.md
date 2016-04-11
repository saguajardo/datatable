[![Total Downloads](https://img.shields.io/packagist/dt/saguajardo/datatable.svg?style=flat)](https://packagist.org/packages/saguajardo/datatable)
[![License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat)](LICENSE)

# Laravel 5 datatable

Datatable for Laravel 5. Con la ayuda de la clase Datatable para Laravel 5, podrán facilmente reutilizar y modificar datatables con consultas ajax.
Por default, se utiliza con Bootstrap 3, pero puede ser utilizado sin ello.

## Documentación
Para la documentación detallada, consultar [http://saguajardo.github.io/datatable](http://saguajardo.github.io/datatable/).

## Changelog
El log de cambios puede encontrarse [aquí](https://github.com/saguajardo/datatable/blob/master/CHANGELOG.md)

###Instalación

``` json
{
    "require": {
        "saguajardo/datatable": "dev-master"
    }
}
```

Ejecutar `composer update`

Luego agregar la siguientes línea en el archivo `config/app.php`, en el apartado `providers`

``` php
    'providers' => [
        // ...
        Saguajardo\Datatable\DatatableServiceProvider::class,
    ]
```

Ahora agregar los Facades (también en el archivo `config/app.php`), apartado `aliases`

``` php
    'aliases' => [
        // ...
        'Datatable'=> Saguajardo\Datatable\Facades\DatatableFacade::class,
        'DatatableBuilder'=> Saguajardo\Datatable\DatatableBuilder::class,
    ]

```

### Quick start

Crear la clase datatables es facil.

Se debe crear el archivo PruebaDatatable.php en el directorio `app/Datatables/` con el siguiente contenido:

```php
<?php 

namespace App\Datatables;

use Saguajardo\Datatable\Datatable;

class PruebaDatatable extends Datatable
{
    public function buildDatatable()
    {
        $this
            ->add('Descripci&oacute;n')
            ->add('Perfil')
            ->add('Acci&oacute;n');
    }
}
```

**Nota**: El directorio puede ser cualquiera que ustedes prefieran. En mi caso, lo cree dentro del directorio app/

Luego de esto, instanciar la clase dentro del controlador y enviarselo a la vista:

```php
<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Saguajardo\Datatable\DatatableBuilder;

class PruebaController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //Construct WelcomeController
    }
	
	public function prueba(DatatableBuilder $datatableBuilder) {
		        // Creo el datatable
        $datatable = $datatableBuilder->create(\App\Datatables\PruebaDatatable::class, [
            'method' => 'GET',
            'url'    => 'listado',
            'data'      => ['id' => 'usuariosTable',
                            'fields' => [
                                'data.descripcion',
                                'data.perfil',
                                'createEditDeleteButton(data.id)',
                            ]
                        ],
        ]);

        return view('prueba', compact('datatable'));
		
	}
	
	public function listado() {
		
		$array[] = array(
			"id" => 10,
			"descripcion" => "Prueba",
			"perfil" => "Admin",
			"id_perfil" => 20,
		);
        
		echo json_encode(array(
            "data" =>
                $array
        ));
	}

}

```

Crear las rutas

```php
// app/Http/routes.php
Route::get('prueba',  array('as' => 'prueba', 'uses' => 'PruebaController@prueba'));
Route::get('listado',  array('as' => 'listado', 'uses' => 'PruebaController@listado'));
```

Imprimir el Datatable en la vista con el Helper `Datatable()`:

```html
<!-- resources/views/prueba.blade.php -->

@extends('app')

@section('content')
    {!! Datatable($datatable) !!}
@endsection
```

Accedemos a la url `/prueba`; El código anterior generará lo siguiente:

<p align="center">
  <img src="https://github.com/saguajardo/datatable/blob/1.1/datatable.JPG" alt="datatable's image"/>
</p>

Para publicar los archivos de configuración se debe ejecutar la siguiente instrucción con artisan:

`php artisan vendor:publish`

Esto creará el archivo `config/datatable.php` (desde donde se podrán modificar las configuraciones de la clase) y las vistas utilizadas en el directorio `resources/views/vendor/datatable/`. En ellas se podrán modificar los templates del datatable a su gusto.
