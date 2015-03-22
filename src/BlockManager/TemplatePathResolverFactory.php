<?php
/**
 * Labofidea (http://www.labofoidea.com)
 * @author    Felipe Almeida <dev@labofidea.com>
 * @link      https://github.com/labofidea/blockmanager for the canonical source repository
 * @copyright Copyright (c) 2011-2015 labofidea. (http://www.labofoidea.com)
 */

namespace BlockManager;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use BlockManager\Resolver\TemplatePathResolver;
class TemplatePathResolverFactory implements FactoryInterface
{   
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator){
        $config = $serviceLocator->get('config');
        $blockManagerConfig = isset($config['block_template_config']) ? $config['block_template_config'] : array();
        return new TemplatePathResolver($blockManagerConfig);
    }
   
}
 