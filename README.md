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
To enable the module you need to add 'BlockManager' to the modules list in the application configuration:
<div class="highlight highlight-php">
<pre>
<?php
return array(
    'modules' => array(
        'BlockManager',
    )
?>
 </div>
</pre>
