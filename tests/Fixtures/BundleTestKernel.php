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
    /**
     * Return list of bundles for running a minimal test kernel.
     *
     * @return \Symfony\Component\HttpKernel\Bundle\BundleInterface[]
     */
    public function registerBundles(): array
    {
        return [
            new DoctrineBundle(),
            new FlowConfigBundle(),
        ];
    }

    /**
     * Load the local configuration for this test kernel.
     *
     * @param \Symfony\Component\Config\Loader\LoaderInterface $loader
     *
     * @throws \Exception
     */
    public function registerContainerConfiguration(LoaderInterface $loader): void
    {
        $loader->load(__DIR__ . '/config/doctrine.yaml');
        $loader->load(__DIR__ . '/config/flow_config.yaml');
    }
}
