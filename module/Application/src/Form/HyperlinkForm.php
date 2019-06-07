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
        
        $this->add([
            'name' => 'URL',
            'type' => Text::class,
            'attributes' => [
                'id' => 'URL',
                'class' => 'form-control',
                'required' => 'true',
            ],
            'options' => [
                'label' => 'URL',
            ],
        ],['priority' => 100]);
        
        $this->add([
            'name' => 'ICON',
            'type' => Text::class,
            'attributes' => [
                'id' => 'ICON',
                'class' => 'form-control',
                'required' => 'true',
            ],
            'options' => [
                'label' => 'Icon',
            ],
        ],['priority' => 100]);
        
        $this->add([
            'name' => 'COLOR',
            'type' => Text::class,
            'attributes' => [
                'id' => 'COLOR',
                'class' => 'form-control',
                'required' => 'true',
            ],
            'options' => [
                'label' => 'Color',
            ],
        ],['priority' => 100]);
        
        $this->add([
            'name' => 'TYPE',
            'type' => Text::class,
            'attributes' => [
                'id' => 'TYPE',
                'class' => 'form-control',
                'required' => 'true',
            ],
            'options' => [
                'label' => 'Type',
            ],
        ],['priority' => 100]);
    }
    
    
}