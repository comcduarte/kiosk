<?php 
namespace Application\Controller;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Join;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Predicate\Like;
use Application\Form\SectionAssignmentForm;

class SectionController extends AbstractBaseController
{
    public function updateAction()
    {
        $view = parent::updateAction();
        $primary_key = $this->params()->fromRoute(strtolower($this->model->getPrimaryKey()),0);
        
        /****************************************
         *          Retrieve Subtable
         ****************************************/
        $sql = new Sql($this->adapter);
        $select = new Select();
        $select->columns(['UUID'])      /*** Get primary Key from Relational Table ***/
            ->from('section_links')
            ->join('links', 'section_links.LINK = links.UUID', ['UUID_L'=>'UUID', 'Caption' => 'CAPTION'], Join::JOIN_INNER)
            ->where([new Like('SECTION', $primary_key)]);
        
        $statement = $sql->prepareStatementForSqlObject($select);
        
        $results = $statement->execute();
        $resultSet = new ResultSet($results);
        $resultSet->initialize($results);
        $links = $resultSet->toArray();
        
        $subtable_params = [
            'title' => 'Links',
            'data' => $links,
            'primary_key' => 'UUID',
            'route' => 'links/default',
            'params' => [
                [
                    'key' => 'UUID_L',
                    'action' => 'update',
                    'route' => 'links/default',
                    'label' => 'Update',
                ],
//                 [
//                     'key' => 'UUID',
//                     'action' => 'unassign',
//                     'route' => 'links/default',
//                     'label' => 'Unassign',
//                 ],
            ],
        ];
        
        $view->setVariable('subtable_params', $subtable_params);
        
        return ($view);
    }
    
    public function assignAction()
    {
        $form = new SectionAssignmentForm('SECTION_ASSIGN_FORM');
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            
            if ($form->isValid()) {
                $data = $request->getPost();
                $this->model->read(['UUID' => $data['SECTION']])->assign($data['LINK']);
                
                $this->flashmessenger()->addSuccessMessage('Successfully assigned hyperlink to section');
            }
        }
        
        $url = $this->getRequest()->getHeader('Referer')->getUri();
        return $this->redirect()->toUrl($url);
    }
    
    public function unassignAction()
    {
        $join_uuid = $this->params()->fromRoute('uuid',0);
        $this->model->unassign(NULL, $join_uuid);
        $url = $this->getRequest()->getHeader('Referer')->getUri();
        return $this->redirect()->toUrl($url);
    }
}