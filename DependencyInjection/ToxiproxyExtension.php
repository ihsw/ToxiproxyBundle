<?php namespace Ihsw\Bundle\ToxiproxyBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension,
    Symfony\Component\DependencyInjection\ContainerBuilder,
    Symfony\Component\DependencyInjection\Loader\YamlFileLoader,
    Symfony\Component\Config\FileLocator;
use GuzzleHttp\Client as HttpClient;
use Ihsw\Bundle\ToxiproxyBundle\DependencyInjection\Configuration,
    Ihsw\Toxiproxy\Toxiproxy;

class ToxiproxyExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        // loading up the user config
        $config = $this->processConfiguration(new Configuration(), $configs);
        foreach ($config as $key => $value) {
            $container->setParameter(sprintf("toxiproxy.%s", $key), $value);
        }
        
        // loading in the services config
        $loader = new YamlFileLoader($container, new FileLocator(sprintf("%s/../Resources/config/", __DIR__)));
        $loader->load("services.yml");

        // starting up the proxies
        $toxiproxy = $container->get("toxiproxy");
        foreach ($config["proxies"] as $proxyName => $proxyParams) {
            $proxy = $toxiproxy->create($proxyName, $proxyParams["upstream"]);
            foreach ($proxyParams["toxics"] as $toxicName => $toxicParams) {
                $proxy->updateDownstream($toxicName, $toxicParams);
            }
        }
    }
}
