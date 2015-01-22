<?php
/**
 * Labofidea (http://www.labofoidea.com)
 * @author    Felipe Almeida <dev@labofidea.com>
 * @link      https://github.com/labofidea/blockmanager for the canonical source repository
 * @copyright Copyright (c) 2011-2015 labofidea. (http://www.labofoidea.com)
 */

namespace BlockManager;

use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ConfigInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
/**
 * Block Manager implementation for blocks
 *
 */
class BlockManager extends ServiceManager implements ServiceLocatorAwareInterface
{
    /**
     * Allow overriding by default
     *
     * @var bool
     */
    protected $allowOverride = true;
    /**
     * The main service locator
     *
     * @var ServiceLocatorInterface
     */
    protected $serviceLocator;
    
    /**
     * Constructor
     *
     * @param  null|ConfigInterface $configuration
     */
    public function __construct(ConfigInterface  $configuration = null)
    {
        parent::__construct($configuration);
                
        $this->addInitializer('BlockManager\BlockInitializer');
    }
    

    /**
     * Retrieve a  registered block
     *
     * @param  string  $name
     * @param  bool    $usePeeringServiceManagers
     * @throws Exception\BlockNotFoundException
     * @return object|array
     */
    public function get($name, $usePeeringServiceManagers = true)
    {
        
        if (!$this->has($name)){
              throw new Exception\BlockNotFoundException(sprintf('Block %s not found.', $name));
        }
        
        $block = parent::get($name,$usePeeringServiceManagers);
        
        if(!$block instanceof \BlockManager\AbstractBlock ){
            throw new Exception\DomainException(sprintf('Block %s must be instance of \BlockManager\AbstractBlock, instance of % given.', $name));
        }
        
        return $block;
    }
    
    /**
     * Set service locator
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    
        return $this;
    }
    
    /**
     * Get service locator
     *
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }
    
}
 