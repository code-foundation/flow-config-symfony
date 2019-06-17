<?php
declare(strict_types=1);

namespace CodeFoundation\FlowConfigBundle\Tests\Fixtures;

use CodeFoundation\FlowConfigBundle\FlowConfigBundle;
use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

/**
 * Kernel for testing FlowConfigBundle
 */
class BundleTestKernel extends Kernel
{
    public function registerBundles()
    {
        return [
            new DoctrineBundle(),
            new FlowConfigBundle(),
        ];
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__ . '/config/doctrine.yaml');
        $loader->load(__DIR__ . '/config/flow_config.yaml');
    }
}
