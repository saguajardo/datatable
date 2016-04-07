<?php  namespace Saguajardo\Datatable;

use Illuminate\Contracts\Container\Container;

class DatatableBuilder
{

    /**
     * @var Container
     */
    protected $container;

    /**
     * @var FormHelper
     */
    protected $datatableHelper;

    /**
     * @param Container  $container
     * @param FormHelper $formHelper
     */
    public function __construct(Container $container, DatatableHelper $datatableHelper)
    {
        $this->container = $container;
        $this->datatableHelper = $datatableHelper;
    }

    /**
     * @param       $formClass
     * @param       $options
     * @param       $data
     * @return Form
     */
    public function create($datatableClass, array $options = [])
    {

        $class = $datatableClass;

        if (!class_exists($class)) {
            throw new \InvalidArgumentException(
                'Datatable class with name ' . $class . ' does not exist.'
            );
        }

        $datatable = $this->container
            ->make($class)
            ->setDatatableHelper($this->datatableHelper)
            ->setDatatableBuilder($this)
            ->setDatatableOptions($options);

        $datatable->buildDatatable();

        return $datatable;
    }

}
