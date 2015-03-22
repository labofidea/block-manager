<?php
namespace BlockManager;

use Zend\ServiceManager\InitializerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use BlockManager\Resolver\TemplatePathResolver;

class BlockInitializer implements InitializerInterface
{
    /**
     * Initialize
     *
     * @param $instance
     * @param ServiceLocatorInterface $serviceLocator
     * @return void
     */
    public function initialize($instance, ServiceLocatorInterface $serviceLocator){
        
        if ($instance  instanceof  \BlockManager\AbstractBlock ){
            $serviceLocator =  $serviceLocator->getServiceLocator();
            $helperPluginManager = $serviceLocator->get('ViewHelperManager');
            $templateResolver = $serviceLocator->get('TemplateResolver');
            $instance->setResolver($templateResolver);
            $instance->setHelperPluginManager($helperPluginManager);
        }
    }
}
 