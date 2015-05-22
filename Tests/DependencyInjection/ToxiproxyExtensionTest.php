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
        $loader = new YamlFileLoader($container, new FileLocator(sprintf("%s/Fixtures/config/", __DIR__)));
        $loader->load($file);
        $container->compile();

        return $container;
    }

    /**
     * @expectedException Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testBlank()
    {
        $this->loadContainerFromFile("blank.yml");
    }

    /**
     * @expectedException Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException
     */
    public function testNonexistent()
    {
        $container = $this->loadContainerFromFile("full.yml");
        $container->getParameter(self::NONEXISTENT_KEY);
    }

    public function testFull()
    {
        $container = $this->loadContainerFromFile("full.yml");
        $this->assertEquals(
            true,
            $container->getParameter("toxiproxy.enabled"),
            "Expected toxiproxy.enabled to be true"
        );
    }
}
