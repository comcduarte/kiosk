<?php 
namespace Application\Model;

use Midnet\Exception\Exception;
use Midnet\Model\DatabaseObject;
use Midnet\Model\Uuid;
use Zend\Db\Sql\Delete;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Sql;

class SectionModel extends DatabaseObject
{
    public $NAME;
    public $PRIORITY;
    
    public function __construct($dbAdapter = null)
    {
        parent::__construct($dbAdapter);
        
        $this->primary_key = 'UUID';
        $this->table = 'sections';
    }
    
    public function assign($link_uuid)
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
            $link_uuid,
            $this->UUID,
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
    
    public function unassign($link_uuid = NULL, $join_uuid = NULL)
    {
        $sql = new Sql($this->dbAdapter);
        
        $delete = new Delete();
        $delete->from('section_links');
        
        if ($link_uuid) {
            $delete->where(['SECTION' => $this->UUID, 'LINK' => $link_uuid]);
        }
        
        if ($join_uuid) {
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
}