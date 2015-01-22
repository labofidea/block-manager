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
            
            $config = (array)$serviceLocator->getServiceLocator()->get('config');
            $helperPluginManager = $serviceLocator->getServiceLocator()->get('ViewHelperManager');
            $blockManagerConfig = $config['block_manager'];
            $resolver = new TemplatePathResolver($blockManagerConfig);
            $instance->setResolver($resolver);
            $instance->setHelperPluginManager($helperPluginManager);
        }
    }
}
 