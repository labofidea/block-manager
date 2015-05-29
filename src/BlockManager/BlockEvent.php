<?php
namespace BlockManager;

use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\EventManager;
 

class BlockEvent extends EventManagerAwareInterface
{
    
    const RENDER_BLOCK_PRE = 'render.block.pre';
    const RENDER_BLOCK_POST = 'render.block.pre';
    
    
    protected $events;
    
    public function setEventManager(EventManagerInterface $events)
    {
        $events->setIdentifiers(array(
            __CLASS__,
            get_called_class(),
        ));
        $this->events = $events;
        return $this;
    }
    
    public function getEventManager()
    {
        if (null === $this->events) {
            $this->setEventManager(new EventManager());
        }
        return $this->events;
    }
}
 