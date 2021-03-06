<?php
/**
 * Labofidea (http://www.labofoidea.com)
 * @author    Felipe Almeida <dev@labofidea.com>
 * @link      https://github.com/labofidea/blockmanager for the canonical source repository
 * @copyright Copyright (c) 2011-2015 labofidea. (http://www.labofoidea.com)
 */

namespace BlockManager\Resolver;
interface ResolverInterface
{
    
    /**
     * Resolve a template name  
     *
     * @param  string $name
     * @return mixed
     */
    public function resolve($name);
    
}
 