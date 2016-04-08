<?php namespace Saguajardo\Datatable;

use Illuminate\Support\ServiceProvider;

class DatatableServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

        $this->registerHtmlIfNeeded();
        $this->registerFormIfHeeded();

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

    /**
     * Add Laravel Form to container if not already set
     */
    private function registerFormIfHeeded()
    {
        if (!$this->app->offsetExists('form')) {

            $this->app->singleton('form', function($app) {

                // LaravelCollective\HtmlBuilder 5.2 is not backward compatible and will throw an exeption
                // https://github.com/kristijanhusak/laravel-form-builder/commit/a36c4b9fbc2047e81a79ac8950d734e37cd7bfb0
                if (substr(Application::VERSION, 0, 3) == '5.2') {
                    $form = new LaravelForm($app['html'], $app['url'], $app['view'], $app['session.store']->getToken());
                }
                else {
                    $form = new LaravelForm($app['html'], $app['url'], $app['session.store']->getToken());
                }

                return $form->setSessionStore($app['session.store']);
            });

            if (! $this->aliasExists('Form')) {

                AliasLoader::getInstance()->alias(
                    'Form',
                    'Collective\Html\FormFacade'
                );
            }
        }
    }

    /**
     * Add Laravel Html to container if not already set
     */
    private function registerHtmlIfNeeded()
    {
        if (!$this->app->offsetExists('html')) {

            $this->app->singleton('html', function($app) {
                return new HtmlBuilder($app['url'], $app['view']);
            });

            if (! $this->aliasExists('Html')) {

                AliasLoader::getInstance()->alias(
                    'HTML',
                    'Collective\Html\HtmlFacade'
                );
            }
        }
    }

}
