<?php
/**
 * Labofidea (http://www.labofoidea.com)
 * @author    Felipe Almeida <dev@labofidea.com>
 * @link      https://github.com/labofidea/blockmanager for the canonical source repository
 * @copyright Copyright (c) 2011-2015 labofidea. (http://www.labofoidea.com)
 */
namespace BlockManager;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ModuleManager\Feature\ViewHelperProviderInterface;
use Zend\ModuleManager\ModuleManager;

class Module implements AutoloaderProviderInterface, ServiceProviderInterface, ViewHelperProviderInterface
{

    public function init(ModuleManager $moduleManager)
    {
        $serviceManager = $moduleManager->getEvent()->getParam('ServiceManager');
        
        if ($serviceManager->has('ServiceListener')) {

            $serviceListener = $serviceManager->get('ServiceListener');
            
            $serviceListener->addServiceManager(
               'BlockManager', 
               'block_manager', 
               'BlockManager\BlockConfigProviderInterface',
               'getBlockConfig'
            );
        }
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/', __NAMESPACE__)
                )
            )
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * Expected to return \Zend\ServiceManager\Config object or array to
     * seed such an object.
     *
     * @return array|\Zend\ServiceManager\Config
     */
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'blockManager' => 'BlockManager\BlockManagerFactory',
                'TemplateResolver'=>'BlockManager\TemplatePathResolverFactory'
            )
        );
    }

    /**
     * Expected to return \Zend\ServiceManager\Config object or array to
     * seed such an object.
     *
     * @return array|\Zend\ServiceManager\Config
     */
    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                'getBlock' => 'BlockManager\BlockHelperFactory'
            )
        );
    }
}
