<?php 
namespace Application\Form\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Application\Form\HyperlinkForm;
use Midnet\Model\Uuid;
use Application\Model\HyperlinkModel;

class HyperlinkFormFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $uuid = new Uuid();
        $adapter = $container->get('hyperlink-model-primary-adapter');
        
        $form = new HyperlinkForm($uuid->value);
        
        $model = new HyperlinkModel();
        $form->setInputFilter($model->getInputFilter());
        $form->setDbAdapter($adapter);
        $form->initialize();
        return $form;
    }

    
}