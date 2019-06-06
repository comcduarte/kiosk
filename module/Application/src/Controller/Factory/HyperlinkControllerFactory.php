<?php 
namespace Application\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Application\Controller\HyperlinkController;
use Application\Model\HyperlinkModel;
use Application\Form\HyperlinkForm;

class HyperlinkControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $controller = new HyperlinkController();
        
        $adapter = $container->get('hyperlink-model-primary-adapter');
        $controller->setDbAdapter($adapter);
        
        $model = new HyperlinkModel($adapter);
        $controller->setModel($model);
        
        $form = $container->get('FormElementManager')->get(HyperlinkForm::class);
        $controller->setForm($form);
        
        return $controller;
    }
}