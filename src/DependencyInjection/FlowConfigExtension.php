<?php
declare(strict_types=1);

namespace CodeFoundation\FlowConfigBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class FlowConfigExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function getAlias(): string
    {
        return 'flow_config';
    }

    /**
     * {@inheritdoc}
     *
     * @param string[][] $configs Additional configuration to process from the flow_config tree.
     *
     * @throws \Symfony\Component\DependencyInjection\Exception\InvalidArgumentException Yaml file is missing a key.
     * @throws \Exception While is not readable/parsable.
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(dirname(__DIR__) . '/Resources/config')
        );
        $loader->load('services.yaml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        # TODO Replace with service definition
        $definition = $container->getDefinition('CodeFoundation\FlowConfig\Repository\ReadonlyConfig');
        $definition->replaceArgument('$config', $config['defaults']);
    }
}
