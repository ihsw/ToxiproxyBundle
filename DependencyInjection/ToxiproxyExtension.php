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
        // loading in the services config
        $loader = new YamlFileLoader($container, new FileLocator(sprintf("%s/../Resources/config/", __DIR__)));
        $loader->load("services.yml");

        // loading up the user config
        $config = $this->processConfiguration(new Configuration(), $configs);

        // hooking up with toxiproxy
        $toxiproxy = new Toxiproxy(new HttpClient(["base_url" => sprintf("http://%s", $config["host"])]));
        foreach ($config["proxies"] as $proxyName => $proxyParams) {
            $proxy = $toxiproxy->create($proxyName, $proxyParams["upstream"]);
            foreach ($proxyParams["toxics"] as $toxicName => $toxicParams) {
                $proxy->updateDownstream($toxicName, $toxicParams);
            }
        }

        // loading toxiproxy into the container
        $container->set("toxiproxy", $toxiproxy);
    }
}
