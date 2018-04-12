<?php
namespace PM\ApiBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        
        $root = $treeBuilder->root('pm_api');
        $root->children()
                ->arrayNode('groups')
                    ->scalarPrototype()
                    ->cannotBeEmpty()
                    ->isRequired()
                    ->defaultValue(['product.id', 'product.name', 'product.description'])
                ->end()
            ->end();
        
        return $treeBuilder;
    }
}

