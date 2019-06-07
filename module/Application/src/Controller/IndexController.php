<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Db\Adapter\AdapterAwareTrait;
use Application\Model\HyperlinkModel;
use Zend\Db\Sql\Where;

class IndexController extends AbstractActionController
{
    use AdapterAwareTrait;
    
    public function indexAction()
    {
        $view = new ViewModel();
        $this->layout('layout/metromega');
        
        $model = new HyperlinkModel($this->adapter);
        
        $data = $model->fetchAll(new Where());
        $view->setVariable('data', $data);
        
        return ($view);
    }
}
