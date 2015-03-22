<?php
/**
 * Labofidea (http://www.labofoidea.com)
 * @author    Felipe Almeida <dev@labofidea.com>
 * @link      https://github.com/labofidea/blockmanager for the canonical source repository
 * @copyright Copyright (c) 2011-2015 labofidea. (http://www.labofoidea.com)
 */
namespace BlockManager\Resolver;

use BlockManager\Exception\InvalidArgumentException;

class TemplatePathResolver implements ResolverInterface
{

    protected $paths = array();

    protected $defaultExtension = 'phtml';

    /**
     * Constructor
     *
     * @param null|array|Traversable $options            
     */
    public function __construct($options = null)
    {
        if ($options) {
            $this->setOptions($options);
        }
    }

    /**
     * Normalize a path
     *
     * @param string $path            
     * @return string
     */
    public static function normalizePath($path)
    {
        $path = rtrim($path, '/');
        $path = rtrim($path, '\\');
        $path .= DIRECTORY_SEPARATOR;
        return $path;
    }

    /**
     * Add a single path to the stack
     *
     * @param string $path            
     * @throws Exception\InvalidArgumentException
     */
    public function addPath($path)
    {
        if (! is_string($path)) {
            throw new InvalidArgumentException(sprintf('Invalid path provided; must be a string, received %s', gettype($path)));
        }
        $this->paths[] = static::normalizePath($path);
        return $this;
    }

    /**
     * Configure object
     *
     * @param array|Traversable $options            
     * @return void
     * @throws Exception\InvalidArgumentException
     */
    public function setOptions($options)
    {
        if (! is_array($options) && ! $options instanceof \Traversable) {
            throw new InvalidArgumentException(sprintf('Expected array or Traversable object; received "%s"', (is_object($options) ? get_class($options) : gettype($options))));
        }
                
        if(isset($options['template_path_stack'])){
            foreach ($options['template_path_stack'] as $path){
                $this->addPath($path);
            }
        }
        
        if (isset($options['defautl_extension'])){
            $this->setDefaultExtension($options['defautl_extension']);
        }
    }
    
    /**
     *
     * @return the $defaultExtension
     */
    public function getDefaultExtension()
    {
        return $this->defaultExtension;
    }

    /**
     *
     * @param string $defaultExtension            
     */
    public function setDefaultExtension($defaultExtension)
    {
        $this->defaultExtension = $defaultExtension;
    }

    /**
     * Resolve a template name
     *
     * @param string $name               
     * @return mixed
     */
    public function resolve($name)
    {
        
        if (preg_match('#\.\.[\\\/]#', $name)) {
            return;
        }
        
        $defaultExtension = $this->getDefaultExtension();
        if (pathinfo($name, PATHINFO_EXTENSION) == '') {
            $name .= '.' . $defaultExtension;
        }
       
        foreach ($this->paths as $path) {
            
            $file = new \SplFileInfo($path . $name);

            if ($file->isReadable()) {
                return $file->getRealPath();
            }
        }
        
        return false;
    }
}
 