<?php 
namespace Application\Form\Factory;

use Application\Form\SectionForm;
use Application\Model\SectionModel;
use Interop\Container\ContainerInterface;
use Midnet\Model\Uuid;
use Zend\ServiceManager\Factory\FactoryInterface;

class SectionFormFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $uuid = new Uuid();
        $adapter = $container->get('hyperlink-model-primary-adapter');
        
        $form = new SectionForm($uuid->value);
        
        $model = new SectionModel();
        $form->setInputFilter($model->getInputFilter());
        $form->setDbAdapter($adapter);
        $form->initialize();
        return $form;
    }

    
}