# block-manager
zend framework 2 module to manage blocks

<article>
 <h2>Installation</h2>
</article>

Installation of this module uses composer. For more information, please refer to 
<a href="http://getcomposer.org/">getcomposer.org</a>

<div class="highlight highlight-sh"><pre>php composer.phar require labofidea/block-manager</pre></div>

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

The Block class need to be a simple object, extending BlockManager\AbstractBlock: <br> 
 
/Application/Block/BannerBlock.php
 
<div class="highlight highlight-php">
<pre>
<span class="pl-pse">&lt;?php</span>

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
 <h3>Block Template</h3>
</article>

Block Templates are mapped based on the block class name.<br> 

 <div class="highlight highlight-sh"><pre>
 As an example, the block class named /Application/Block/BannerBlock.php, would be mapped to the template<br> /Application/view/Block/banner-block.phtml
   </pre></div>

/Application/view/Block/banner-block.phtml

<div class="highlight highlight-php">
<pre>
<span class="pl-pse">&lt;?php</span>
  foreach($this->getAll() as $banner):
  
?>
 &lt;img src="banners/<span class="pl-pse">&lt;?php</span> echo $banner; ?>" >
 <span class="pl-pse">&lt;?php</span>
  endforeach;
 ?>
</pre>
</div>
 
<article>
 <h3>Config Block Class</h3>
</article>

Configuration requires a block_manager key in the module config file or the method getBlockConfig(),implemented by<br> BlockManager\BlockConfigProviderInterface, in the module class:<br>
 
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
 <h3>Config Block Template</h3>
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
 
 <article>
 <h3>Render Block</h3>
</article>

To Render a block you need to use getBlock helper :<br>
  
/view/index/index.phtml

<div class="highlight highlight-php">
<pre>
 <span class="pl-pse">&lt;?php</span> echo $this->getblock('bannerBlock'); ?>
</pre>
</div>
