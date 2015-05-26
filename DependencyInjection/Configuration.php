<?php namespace Ihsw\Bundle\ToxiproxyBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder,
    Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root("toxiproxy");
        $rootNode
            ->children()
                ->scalarNode("host")->isRequired()->cannotBeEmpty()->end()
                ->arrayNode("proxies")
                    ->isRequired()
                    ->requiresAtLeastOneElement()
                    ->useAttributeAsKey("name")
                    ->prototype("array")
                        ->children()
                            ->scalarNode("upstream")->isRequired()->cannotBeEmpty()->end()
                            ->arrayNode("toxics")
                                ->isRequired()
                                ->children()
                                    ->arrayNode("bandwidth")
                                        ->children()
                                            ->booleanNode("enabled")->defaultTrue()->end()
                                            ->floatNode("rate")->isRequired()->cannotBeEmpty()->end()
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}