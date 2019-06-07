<?php 
namespace Application\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Application\Controller\IndexController;

class IndexControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $adapter = $container->get('hyperlink-model-primary-adapter');
        $controller = new IndexController();
        $controller->setDbAdapter($adapter);
        return $controller;
    }
}