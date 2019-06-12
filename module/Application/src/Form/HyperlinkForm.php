<?php 
namespace Application\Form;

use Zend\Db\Adapter\AdapterAwareTrait;
use Zend\Form\Element\File;
use Zend\Form\Element\Text;
use Zend\Form\Element\Select;

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
            ],
            'options' => [
                'label' => 'Color',
            ],
        ],['priority' => 100]);
        
        $this->add([
            'name' => 'TYPE',
            'type' => Select::class,
            'attributes' => [
                'id' => 'TYPE',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Type',
                'value_options' => [
                    'icon-featurecw' => 'icon-featurecw',
                ],
            ],
            
        ],['priority' => 100]);
        
        $this->add([
            'name' => 'PRIORITY',
            'type' => Text::class,
            'attributes' => [
                'id' => 'PRIORITY',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Priority',
            ],
        ],['priority' => 100]);
        
        $this->add([
            'name' => 'PDF',
            'type' => File::class,
            'attributes' => [
                'id' => 'PDF',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Upload PDF',
            ],
        ],['priority' => 100]);
    }
    
    
}