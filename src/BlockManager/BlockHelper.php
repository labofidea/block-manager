<?php
/**
 * Labofidea (http://www.labofoidea.com)
 * @author    Felipe Almeida <dev@labofidea.com>
 * @link      https://github.com/labofidea/blockmanager for the canonical source repository
 * @copyright Copyright (c) 2011-2015 labofidea. (http://www.labofoidea.com)
 */
namespace BlockManager;

use Zend\View\Helper\AbstractHelper;
use BlockManager\Renderer\BlockRenderer;
use BlockManager\BlockManager;
 
class BlockHelper extends AbstractHelper
{

    /**
     *
     * @var BlockManager
     */
    protected $blockManager;

    /**
     *
     * @var blockRenderer
     */
    protected $blockRenderer;
    
    
    /**
     * Constructor
     * 
     * @param BlockManager $blockManager
     */
    public function __construct(BlockManager $blockManager = null){
        
        if ($blockManager) {
            $this->setBlockManager($blockManager);
        }
 
    }

    /**
     *
     * @param BlockManager $blockManager            
     */
    public function setBlockManager(BlockManager $blockManager)
    {
        $this->blockManager = $blockManager;
    }


    /**
     *
     * @param string $name            
     */
    public function __invoke($name)
    {
       return  $this->blockManager->get($name)->render();
    }
}
 