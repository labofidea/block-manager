# block-manager
zend framework 2 module to manage block classes

<article>
 <h2>Installation</h2>
</article>

Installation of this module uses composer. For more information, please refer to 
<a href="http://getcomposer.org/">getcomposer.org</a>

<div class="highlight highlight-sh"><pre>php composer.phar require labofidea/block-manager</div>

<article>
 <h3>Enabling Module</h3>
</article>
 
To enable the module you need to add 'BlockManager' to the modules list in the application configuration file:
 
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
 <h3>Block Class</h3>
</article>

Blocks classes, need to be simple objects extending BlockManager\AbstractBlock:<br> 
 
 /Application/Block/BannerBlock.php
 
<div class="highlight highlight-php">
<pre>
<span class="pl-pse">&lt;?php</span>
<?php
namespace Application\Block;

use BlockManager\AbstractBlock;
class BannerBlock extends AbstractBlock
{
    public function getAll(){
        return array(
        'banner1.jpg',
        'banner2.jpg',
        'banner3.jpg',
        );
    }
}
...
</pre>
</div>
 
<article>
 <h3>Config block</h3>
</article>

Configuration requires a block_manager key in the module config file or the module class file:<br>
 
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

<article>
 <h3>Config block templates</h3>
</article>

Block template configuration requires a block_template_config key in the module config file :<br>
 
/config/module.config.php

<div class="highlight highlight-php">
<pre>
<span class="pl-pse">&lt;?php</span>
return array(
    'block_template_config'=> array(
        'template_path_stack'=> array(
            __DIR__ . '/../view/block'
       )
     ),
   ),
 ...
 </pre>
 </div>
