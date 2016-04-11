<?php namespace Saguajardo\Datatable;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Application;

class DatatableServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

        $this->mergeConfigFrom(
            __DIR__ . '/Config/config.php',
            'datatable'
        );

        $this->registerDatatableHelper();

        $this->app->singleton('datatable', function ($app) {

            return new DatatableBuilder($app, $app['datatable-helper']);
        });

        $this->app->alias('datatable', 'Saguajardo\Datatable\DatatableBuilder');

    }

    protected function registerDatatableHelper()
    {
        $this->app->singleton('datatable-helper', function ($app) {

            $configuration = $app['config']->get('datatable');

            return new DatatableHelper($app['view'], $configuration);
        });

        $this->app->alias('datatable-helper', 'Saguajardo\Datatable\DatatableHelper');
    }

    public function boot()
    {
		// cargar las vistas (por ahora no lo utilizo)
        $this->loadViewsFrom(__DIR__.'/views', 'datatable');

        $this->publishes([
            __DIR__ . '/views' => base_path('resources/views/vendor/datatable'),
            __DIR__ . '/config/config.php' => config_path('datatable.php')
        ]);
    }
	
    /**
     * @return string[]
     */
    public function provides()
    {
        return ['datatable'];
    }

}
