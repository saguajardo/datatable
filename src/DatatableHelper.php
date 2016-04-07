<?php namespace Saguajardo\Datatable;

use Illuminate\Support\Collection;
use Illuminate\Contracts\View\Factory as View;

class DatatableHelper
{

    /**
     * @var View
     */
    protected $view;

    /**
     * @var array
     */
    protected $config;

    /**
     * @param View    $view
     * @param array   $config
     */
    public function __construct(View $view, array $config = [])
    {
        $this->view = $view;
        $this->config = $config;
    }

    /**
     * @param string $key
     * @param string $default
     * @return mixed
     */
    public function getConfig($key, $default = null)
    {
        return array_get($this->config, $key, $default);
    }

    /**
     * @return View
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * Merge options array
     *
     * @param array $first
     * @param array $second
     * @return array
     */
    public function mergeOptions(array $first, array $second)
    {
        return array_replace_recursive($first, $second);
    }

}
