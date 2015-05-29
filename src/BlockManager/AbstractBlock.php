<?php
/**
 * Labofidea (http://www.labofoidea.com)
 * @author    Felipe Almeida <dev@labofidea.com>
 * @link      https://github.com/labofidea/blockmanager for the canonical source repository
 * @copyright Copyright (c) 2011-2015 labofidea. (http://www.labofoidea.com)
 */

namespace BlockManager;
 
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\View\HelperPluginManager;
use BlockManager\Exception\InvalidArgumentException;
use BlockManager\Exception\RuntimeException;
use BlockManager\Exception\DomainException;
use BlockManager\Resolver\ResolverInterface;


abstract class AbstractBlock implements EventManagerAwareInterface
{
    
    const RENDER_BEFORE_BLOCK_EVENT = 'render.block.before';
    const RENDER_AFTER_BLOCK_EVENT = 'render.block.after';
    /**
     * Template resolver
     *
     * @var Resolver
     */
    private $templateResolver;
    /**
     * Helper plugin manager
     *
     * @var HelperPluginManager
     */
    private $HelperPluginManager;
    /**
     * @var array Cache for helpers call
     */
    private $helpersCache = array();
    /**
     * @var event manager  $eventManager
     */
    private $eventManager = null;
    /**
     * Set the event manager instance  
     *
     * @param  EventManagerInterface $eventManager
     * @return AbstractBlock
     */
    public function setEventManager(EventManagerInterface $eventManager)
    {
        $this->eventManager = $eventManager; 
        return $this;
    }
    /**
     * Retrieve the event manager
     *
     * @return EventManagerInterface
     */
    public function getEventManager()
    {   
        return $this->eventManager;
    }
    
    /**
     * Processes a view script and returns the output.
     * @param string | null $name
     * @throws RuntimeException
     * @return string The script output.
     */
    public function render($name = null){
    
        $reflection = new \ReflectionClass($this);
        $fileName = self::normalizeClassName($reflection->getShortName());
        $file = $this->resolver($fileName);
        $content = '';
       
        if(!$file){
            throw new RuntimeException(sprintf('Invalid Template %s.',$fileName));
        }
    
        try {
            ob_start();
            $this->getEventManager()->trigger(self::RENDER_BEFORE_BLOCK_EVENT);
            $this->getEventManager()->trigger(self::RENDER_AFTER_BLOCK_EVENT);
            $file =  include $file;
            $content = ob_get_clean();
            
        }catch (\Exception $e){
            ob_end_clean();
             throw new RuntimeException(sprintf('Error when trying render %s.',$fileName));
        }
         
        return $content;
    }
    
    /**
     *  helpers
     *
     * @param  string $method
     * @param  array $argv
     * @throws DomainException
     * @return mixed
     */
    public function __call($method, $argv)
    {
         
        if (!$this->getHelperPluginManager()->has($method) && !method_exists($this, $method)){
              throw new DomainException(sprintf('Invalid method named %s.',$method));         
        }
        
        return $this->getHelper($method, $argv);
    }
     
    /**
     * retrieve normalize class name
     *
     * @param  null|string $className
     * @return string
     */
    public static function normalizeClassName($className){
         
        return strtolower(preg_replace('([A-Z])', '-$0', lcfirst($className)));
         
    }
     
    /**
     * Retrieve template name or template resolver
     *
     * @param  null|string $name
     * @return string|Resolver
     */
    public function resolver($name = null)
    {
        if ($name) {
            return $this->templateResolver->resolve($name);
        }
         
        return $this->templateResolver;
    }
    /**
     * Set script resolver
     *
     * @param  Resolver $resolver
     */
    public function setResolver(ResolverInterface $resolver)
    {
        $this->templateResolver = $resolver;
        return $this;
    }
      
    /**
     *
     * @param HelperPluginManager $HelperPluginManager
     */
    public function setHelperPluginManager($HelperPluginManager)
    {
        if (!$HelperPluginManager instanceof HelperPluginManager) {
            throw new InvalidArgumentException(sprintf(
                'Helper helpers must extend Zend\View\HelperPluginManager; got type "%s" instead',
                (is_object($HelperPluginManager) ? get_class($HelperPluginManager) : gettype($HelperPluginManager))
            ));
        }
         
        $this->HelperPluginManager = $HelperPluginManager;
         
        return $this;
    }
     
    /**
     *
     * @return the $HelperPluginManager
     */
    public function getHelperPluginManager()
    {
        return $this->HelperPluginManager;
    }
     
    /**
     * @param string $name
     * @param array  $args
     * @return mixed
     */
    protected function getHelper($name,$args){
    
        if (! isset($this->helpersCache[$name])) {
            $this->helpersCache[$name] = $this->getHelperPluginManager()->get($name);
        }
         
        if (is_callable($this->helpersCache[$name])) {
            return call_user_func_array($this->helpersCache[$name], $args);
        }
         
        return $this->helpersCache[$name];
    }
} 