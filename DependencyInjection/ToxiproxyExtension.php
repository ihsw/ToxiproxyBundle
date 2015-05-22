<?php namespace Ihsw\Bundle\ToxiproxyBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension,
    Symfony\Component\DependencyInjection\ContainerBuilder;
use Ihsw\Bundle\ToxiproxyBundle\DependencyInjection\Configuration;

class ToxiproxyExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
    	$config = $this->processConfiguration(new Configuration(), $configs);
    	foreach ($config as $key => $value) {
    		$container->setParameter(sprintf("toxiproxy.%s", $key), $value);
    	}
    }
}
