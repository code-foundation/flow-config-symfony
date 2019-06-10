<?php
declare(strict_types=1);

namespace CodeFoundation\Bundle\FlowConfigBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;

class CodeFoundationFlowConfigExtension extends Extension
{
    public function getAlias(): string
    {
        return 'flow_config';
    }

    public function load(array $configs, ContainerBuilder $container)
    {
    }
}
