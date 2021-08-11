<?php 
namespace Application\Controller\Factory;

use Application\Controller\SectionController;
use Application\Form\SectionForm;
use Application\Model\SectionModel;
use Interop\Container\ContainerInterface;
use Midnet\Model\Uuid;
use Zend\ServiceManager\Factory\FactoryInterface;

class SectionControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $controller = new SectionController();
        $uuid = new Uuid();
        $date = new \DateTime('now',new \DateTimeZone('EDT'));
        $today = $date->format('Y-m-d H:i:s');
        
        $adapter = $container->get('hyperlink-model-primary-adapter');
        $controller->setDbAdapter($adapter);
        
        $model = new SectionModel($adapter);
        $model->UUID = $uuid->value;
        $model->DATE_CREATED = $today;
        $model->STATUS = $model::ACTIVE_STATUS;
        $controller->setModel($model);
        
        $form = $container->get('FormElementManager')->get(SectionForm::class);
        $controller->setForm($form);
        
        return $controller;
    }
}