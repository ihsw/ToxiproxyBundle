<?php namespace Ihsw\Bundle\ToxiproxyBundle\Tests;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Ihsw\Bundle\ToxiproxyBundle\ToxiproxyBundle;

class BundleTest extends \PHPUnit_Framework_TestCase
{
    public function testBuildBundleContainer()
    {
        $container = new ContainerBuilder();
        $bundle = new ToxiproxyBundle();
        $bundle->build($container);
    }
}