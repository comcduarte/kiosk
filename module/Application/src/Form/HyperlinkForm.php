<?php 
namespace Application\Form;

use Zend\Db\Adapter\AdapterAwareTrait;
use Zend\Form\Element\Text;

class HyperlinkForm extends AbstractBaseForm
{
    use AdapterAwareTrait;
    
    public function initialize()
    {
        parent::initialize();
        
        $this->add([
            'name' => 'CAPTION',
            'type' => Text::class,
            'attributes' => [
                'id' => 'CAPTION',
                'class' => 'form-control',
                'required' => 'true',
            ],
            'options' => [
                'label' => 'Caption',
            ],
        ],['priority' => 100]);
    }
}