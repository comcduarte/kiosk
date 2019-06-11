<?php 
namespace Application\Model;

use Midnet\Model\DatabaseObject;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\InputFilter\FileInput;
use Zend\InputFilter\InputFilter;

class HyperlinkModel extends DatabaseObject
{
    public $CAPTION;
    public $URL;
    public $ICON;
    public $COLOR;
    public $TYPE;
    
    public function __construct($dbAdapter = null)
    {
        parent::__construct($dbAdapter);
        
        $this->primary_key = 'UUID';
        $this->table = 'links';
    }
    
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            
            foreach ($this->public_attributes as $var) {
                $inputFilter->add([
                    'name' => $var,
                    'required' => $this->required,
                    'filters' => [
                        ['name' => StripTags::class],
                        ['name' => StringTrim::class],
                    ],
                ]);
            }
            
            $inputFilter->add([
                'name' => 'PDF',
                'required' => FALSE,
                'filters' => [
                    [
                        'name' => 'filerenameupload',
                        'options' => [
                            'target'    => './data/pdf/' . $this->UUID . '.pdf',
                            'overwrite' => TRUE,
                            'randomize' => FALSE,
                        ],
                    ],
                ],
                'validators' => [
                    [
                        'name'    => 'FileMimeType',
                        'options' => [
                            'mimeType'  => ['application/pdf']
                        ]
                    ],
                ],
            ]);
            
            $fileInput = new FileInput('PDF');
            $fileInput->setRequired(FALSE);
            $fileInput->getFilterChain()->attachByName(
                'filerenameupload',
                [
                    'target'    => './data/pdf/' . $this->UUID . '.pdf',
                    'overwrite' => true,
                ]);
            $inputFilter->add($fileInput);
            
            $this->inputFilter = $inputFilter;
        }
        return $this->inputFilter;
    }
}