<?php namespace Saguajardo\Datatable;

trait DatatableBuilderTrait
{

    /**
     * Create a Form instance
     *
     * @param string $name Full class name of the form class
     * @param array  $options Options to pass to the form
     * @param array  $data additional data to pass to the form
     *
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function datatable($name, array $options = [], array $data = [])
    {
        return \App::make('datatable')->create($name, $options, $data);
    }

    /**
     * Create a plain Form instance
     *
     * @param array $options Options to pass to the form
     * @param array $data additional data to pass to the form
     *
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function plain(array $options = [], array $data = [])
    {
        return \App::make('datatable')->plain($options, $data);
    }
}