<?php
declare(strict_types=1);

namespace CodeFoundation\Bundle\FlowConfigBundle\DependencyInjection;

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
        $rootNode
            ->children()
                ->arrayNode('defaults')
                #->requiresAtLeastOneElement()
                #->useAttributeAsKey('name')
               ->prototype('scalar')->end()
            ->end()
        ;

        return $treeBuilder;
    }
}