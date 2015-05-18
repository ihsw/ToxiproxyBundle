<?php namespace Ihsw\Bundle\ToxiproxyBundle\Tests\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder,
    Symfony\Component\DependencyInjection\Loader\YamlFileLoader,
    Symfony\Component\Config\FileLocator;
use Ihsw\Bundle\ToxiproxyBundle\DependencyInjection\ToxiproxyExtension;

class SwiftmailerExtensionTest extends \PHPUnit_Framework_TestCase
{
    const NONEXISTENT_KEY = "toxiproxy.non-existent";

    private function loadContainerFromFile($file)
    {
        // starting up the container
        $container = new ContainerBuilder();
        $container->setParameter("kernel.debug", false);
        $container->setParameter("kernel.cache_dir", "/tmp");
        $container->registerExtension(new ToxiproxyExtension());

        // loading in the test config
        $locator = new FileLocator(sprintf("%s/Fixtures/config/", __DIR__));
        $loader = new YamlFileLoader($container, $locator);
        $loader->load($file);

        // ????
        $container->getCompilerPassConfig()->setOptimizationPasses([]);
        $container->getCompilerPassConfig()->setRemovingPasses([]);
        $container->compile();

        return $container;
    }

    /**
     * @expectedException Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException
     */
    public function testBlank()
    {
        $container = $this->loadContainerFromFile("blank.yml");
        $container->getParameter(self::NONEXISTENT_KEY);
    }
}
