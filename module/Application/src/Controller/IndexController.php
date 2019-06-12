<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Application\Model\HyperlinkModel;
use Midnet\Exception\Exception;
use Zend\Db\Adapter\AdapterAwareTrait;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Join;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Where;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    use AdapterAwareTrait;
    
    public function indexAction()
    {
        $view = new ViewModel();
        $this->layout('layout/metromega');
        
        $model = new HyperlinkModel($this->adapter);
       
        /*******************************/
        
        $sql = new Sql($this->adapter);
        
        $select = new Select();
        $select->from('section_links')
            ->join('links', 'section_links.LINK = links.UUID', ['*'], Join::JOIN_INNER)
            ->join('sections', 'section_links.SECTION = sections.UUID', ['UUID_S'=>'UUID', 'Name' => 'NAME'], Join::JOIN_INNER);
        $predicate = new Where();
        $predicate->equalTo('links.STATUS', $model::ACTIVE_STATUS);
        $select->where($predicate);
        $select->order(['sections.PRIORITY', 'links.PRIORITY']);
        
        $statement = $sql->prepareStatementForSqlObject($select);
        $resultSet = new ResultSet();
        try {
            $results = $statement->execute();
            $resultSet->initialize($results);
        } catch (Exception $e) {
            return $e;
        }
        
        $data = [];
        
        foreach ($resultSet->toArray() as $record) {
            $data[$record['Name']][] = $record;
        }
        
        
        $view->setVariable('data', $data);
        return ($view);
    }
}
