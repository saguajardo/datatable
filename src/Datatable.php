<?php

namespace Saguajardo\Datatable;

use Illuminate\Support\Facades\View;
use Illuminate\Contracts\Validation\Factory as ValidatorFactory;
use Illuminate\Http\Request;

class Datatable {

    /**
     * @var DatatableHelper
     */
    private $datatableHelper;

    /**
     * @var  fields
     */
    private $fields;

    /**
     * @var DatatableBuilder
     */
    private $datatableBuilder;

    /**
     * Datatable options
     *
     * @var array
     */
    protected $datatableOptions = [
        'method' => 'POST',
        'url' => null
    ];

    /**
     * Additional data which can be used to build fields
     *
     * @var array
     */
    protected $data = [];


    /**
     * Name of the parent form if any
     *
     * @var string|null
     */
    protected $name = null;

    /**
     * Constructor de la clase
     */
    public function __construct() {
        $this->fields = [];
    }

    /**
     * Get field dynamically
     *
     * @param $name
     * @return FormField
     */
    public function __get($name)
    {
        if ($this->has($name)) {
            return $this->getField($name);
        }
    }

    /**
     * Set the datatable helper only on first instantiation
     *
     * @param DatatableHelper $datatableHelper
     * @return $this
     */
    public function setDatatableHelper(DatatableHelper $datatableHelper)
    {
        $this->datatableHelper = $datatableHelper;

        return $this;
    }

    /**
     * Set datatable builder instance on helper so we can use it later
     *
     * @param DatatableBuilder $datatableBuilder
     * @return $this
     */
    public function setDatatableBuilder(DatatableBuilder $datatableBuilder)
    {
        $this->datatableBuilder = $datatableBuilder;

        return $this;
    }

    /**
     * Get datatable helper
     *
     * @return DatatableHelper
     */
    public function getDatatableHelper()
    {
        return $this->datatableHelper;
    }

    /**
     * Get all datatable options
     *
     * @return array
     */
    public function getDatatableOptions()
    {
        return $this->datatableOptions;
    }

    /**
     * Get single datatable option
     *
     * @param string $option
     * @param $default
     * @return mixed
     */
    public function getDatatableOption($option, $default = null)
    {
        return array_get($this->datatableOptions, $option, $default);
    }

    /**
     * Set single datatable option on datatable
     *
     * @param string $option
     * @param mixed $value
     *
     * @return $this
     */
    public function setDatatableOption($option, $value)
    {
        $this->datatableOptions[$option] = $value;

        return $this;
    }

    /**
     * Build the datatable
     *
     * @return mixed
     */
    public function buildDatatable()
    {
    }

    /**
     * Create a new field and add it to the form
     *
     * @param string $name
     * @param string $type
     * @param array  $options
     * @param bool   $modify
     * @return $this
     */
    public function add($name, $modify = false)
    {
        if (!$name || trim($name) == '') {
            throw new \InvalidArgumentException(
                'Please provide valid field name for class ['. get_class($this) .']'
            );
        }

        $this->addField($name);

        return $this;
    }

    /**
     * Add Field to the Datatables
     *
     * @param string $field
     * @return $this
     */
    protected function addField($name) {

        $this->preventDuplicate($name);

        $this->fields[$name] = $name;

        return $this;
    }
    
    /**
     * Prevent adding fields with same name
     *
     * @param string $name
     */
    protected function preventDuplicate($name)
    {
        if ($this->has($name)) {
            throw new \InvalidArgumentException('Field ['.$name.'] already exists in the form '.get_class($this));
        }
    }

    /**
     * Check if form has field
     *
     * @param $name
     * @return bool
     */
    public function has($name)
    {
        return array_key_exists($name, $this->fields);
    }


    /**
     * Set datatable options
     *
     * @param array $datatableOptions
     * @return $this
     */
    public function setDatatableOptions($datatableOptions)
    {

        $this->datatableOptions = $this->datatableHelper->mergeOptions($this->datatableOptions, $datatableOptions);
        
        return $this;
    }

    /**
     * Render the Table
     *
     * @param $options
     * @return string
     */
    protected function renderTable($options)
    {

        $datatableOptions = $this->datatableHelper->mergeOptions($this->datatableOptions, $options);

        return $this->datatableHelper->getView()
            ->make($this->getTemplateTable())
            ->with('id', $datatableOptions['data']['id'])
            ->with('class', $this->datatableHelper->getConfig('class'))
            ->with('options', $this->datatableHelper->getConfig('options'))
            ->with('fields', $this->fields)
            ->render();

    }

    /**
     * Render the Script
     *
     * @return string
     */
    protected function renderScript()
    {

        return $this->datatableHelper->getView()
            ->make($this->getTemplateScript())
            ->with('id', $this->datatableOptions['data']['id'])
            ->with('url', $this->datatableOptions['url'])
            ->with('method', $this->datatableOptions['method'])
            ->with('filter', $this->datatableHelper->getConfig('filter'))
            ->with('ordering', $this->datatableHelper->getConfig('ordering'))
            ->with('fields', $this->datatableOptions['data']['fields'])
            ->render();

    }

    /**
     * Render full datatable
     *
     * @param array $options
     * @param bool  $showStart
     * @param bool  $showFields
     * @param bool  $showEnd
     * @return string
     */
    public function renderDatatable(array $options = [])
    {
        return $this->renderTable($options) . $this->renderScript();
    }

    /**
     * Get template from options if provided, otherwise fallback to config
     *
     * @return mixed
     */
    protected function getTemplateTable()
    {
        return $this->getDatatableOption('template', $this->datatableHelper->getConfig('table'));
    }

    /**
     * Get template from options if provided, otherwise fallback to config
     *
     * @return mixed
     */
    protected function getTemplateScript()
    {
        return $this->getDatatableOption('template', $this->datatableHelper->getConfig('script'));
    }

}