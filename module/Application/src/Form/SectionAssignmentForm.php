<?php 
namespace Application\Form;

use Midnet\Form\Element\DatabaseSelectObject;
use Zend\Db\Adapter\AdapterAwareTrait;
use Zend\Form\Element\Hidden;

class SectionAssignmentForm extends AbstractBaseForm
{
    use AdapterAwareTrait;
    
    public function initialize()
    {
        parent::initialize();
        
        $this->add([
            'name' => 'SECTION',
            'type' => DatabaseSelectObject::class,
            'attributes' => [
                'id' => 'SECTION',
                'class' => 'form-control',
                'required' => 'true',
            ],
            'options' => [
                'label' => 'Section',
                'database_adapter' => $this->adapter,
                'database_table' => 'sections',
                'database_id_column' => 'UUID',
                'database_value_column' => 'NAME',
            ],
        ],['priority' => 100]);
        
        $this->add([
            'name' => 'LINK',
            'type' => Hidden::class,
            'attributes' => [
                'id' => 'LINK',
                'class' => 'form-control',
            ],
        ],['priority' => 0]);
        
        $this->remove('UUID');
        $this->remove('STATUS');
    }
}