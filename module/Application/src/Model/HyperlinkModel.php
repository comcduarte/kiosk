<?php 
namespace Application\Model;

use Midnet\Exception\Exception;
use Midnet\Model\DatabaseObject;
use Midnet\Model\Uuid;
use Zend\Db\Sql\Delete;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Sql;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\InputFilter\FileInput;
use Zend\InputFilter\InputFilter;
use const Zend\Validator\NotEmpty\NULL;

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
    
    public function assign($section_uuid)
    {
        $sql = new Sql($this->dbAdapter);
        $uuid = new Uuid();
        
        $columns = [
            'UUID',
            'LINK',
            'SECTION',
        ];
        
        $values = [
            $uuid->value,
            $this->UUID,
            $section_uuid,
        ];
        
        $insert = new Insert();
        $insert->into('section_links');
        $insert->columns($columns);
        $insert->values($values);
        
        $statement = $sql->prepareStatementForSqlObject($insert);
        
        try {
            $statement->execute();
        } catch (Exception $e) {
            return $e;
        }
        return $this;
    }
    
    public function unassign($section_uuid = NULL, $join_uuid = NULL)
    {
        $sql = new Sql($this->dbAdapter);
        
        $delete = new Delete();
        $delete->from('section_links');
        
        if ($section_uuid != NULL ) {
            $delete->where(['LINK' => $this->UUID, 'SECTION' => $section_uuid]);
        }
        
        if ($join_uuid != NULL) {
            $delete->where(['UUID' => $join_uuid]);
        }
        
        $statement = $sql->prepareStatementForSqlObject($delete);
        
        try {
            $statement->execute();
        } catch (Exception $e) {
            return $e;
        }
        return $this;
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