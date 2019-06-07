<?php 
namespace Application\Controller\Factory;

use Application\Controller\HyperlinkController;
use Application\Form\HyperlinkForm;
use Application\Model\HyperlinkModel;
use Interop\Container\ContainerInterface;
use Midnet\Model\Uuid;
use Zend\ServiceManager\Factory\FactoryInterface;

class HyperlinkControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $controller = new HyperlinkController();
        $uuid = new Uuid();
        $date = new \DateTime('now',new \DateTimeZone('EDT'));
        $today = $date->format('Y-m-d H:i:s');
        
        $adapter = $container->get('hyperlink-model-primary-adapter');
        $controller->setDbAdapter($adapter);
        
        $model = new HyperlinkModel($adapter);
        $model->UUID = $uuid->value;
        $model->DATE_CREATED = $today;
        $model->STATUS = $model::ACTIVE_STATUS;
        $controller->setModel($model);
        
        $form = $container->get('FormElementManager')->get(HyperlinkForm::class);
        $controller->setForm($form);
        
        return $controller;
    }
}