<?php
/**
 * Labofidea (http://www.labofoidea.com)
 * @author    Felipe Almeida <dev@labofidea.com>
 * @link      https://github.com/labofidea/blockmanager for the canonical source repository
 * @copyright Copyright (c) 2011-2015 labofidea. (http://www.labofoidea.com)
 */

namespace BlockManager;
use Zend\ServiceManager\Config;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class BlockManagerFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return BlockManager
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('config');
        $blockManagerConfig = isset($config['block_manager']) ? $config['block_manager'] : array();
        return new BlockManager(new Config($blockManagerConfig));
    }
}
 