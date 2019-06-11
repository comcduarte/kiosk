<?php 
namespace Application\Model;

use Midnet\Model\DatabaseObject;

class SectionModel extends DatabaseObject
{
    public $NAME;
    
    public function __construct($dbAdapter = null)
    {
        parent::__construct($dbAdapter);
        
        $this->primary_key = 'UUID';
        $this->table = 'sections';
    }
}