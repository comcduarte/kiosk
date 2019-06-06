<?php 
namespace Application\Model;

use Midnet\Model\DatabaseObject;

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
}