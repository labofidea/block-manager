# block-manager
zend framework 2 module to manage block classes

<article>
 <h2>Installation</h2>
</article>

Installation of this module uses composer. For more information, please refer to 
<a href="http://getcomposer.org/">getcomposer.org</a>

<div class="highlight highlight-sh"><pre>php composer.phar require labofidea/block-manager</div>

<article>
 <h4>Enabling Module</h4>
</article>
<article>
To enable the module you need to add 'BlockManager' to the modules list in the application configuration file:
</article>
<div class="highlight highlight-php">
<pre>
<span class="pl-pse">&lt;?php</span>
return array(
    'modules' => array(
        'BlockManager',
    )
    ...
)
</pre>
 </div>
 
<article>
 <h4>Configuration</h4>
</article>

Configuration requires a block_manager key in the module config file or the module file:

/config/module.config.php

<div class="highlight highlight-php">
<pre>
<span class="pl-pse">&lt;?php</span>
return array(
    'block_manager' => array(
        'invokables' => array(
            'menuBlock' => 'Application\Block\Menu'
        ),
    ),
 ...
 
</pre>
 </div>
 
 /module.php
 
<div class="highlight highlight-php">
<pre>
<span class="pl-pse">&lt;?php</span>
namespace Application;
use BlockManager\BlockConfigProviderInterface;

class Module implements BlockConfigProviderInterface
{

    /**
     * config Block classes
     *
     * @return array
     */
    public function getBlockConfig()
    {
         return array(
            'invokables' => array(
                'bannerBlock' => 'Application\Block\BannerBlock',
            ),
        );
    }
...
 
</pre>
</div>
