<?php
declare(strict_types=1);

namespace CodeFoundation\FlowConfigBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ParentNodeDefinitionInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('flow_config');
        $rootNode = $treeBuilder->getRootNode();

        if ($rootNode instanceof ParentNodeDefinitionInterface === false) {
            return $treeBuilder;
        }

        $rootNode
            ->children()
                ->arrayNode('defaults')
               ->prototype('scalar')->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
