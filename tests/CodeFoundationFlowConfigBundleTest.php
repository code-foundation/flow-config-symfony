<?php
declare(strict_types=1);

namespace Tests\CodeFoundation\Bundle\FlowConfigBundle;

use CodeFoundation\Bundle\FlowConfigBundle\CodeFoundationFlowConfigBundle;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @covers \CodeFoundation\Bundle\FlowConfigBundle\CodeFoundationFlowConfigBundle
 */
class CodeFoundationFlowConfigBundleTest extends TestCase
{
    /**
     * Test the alias naming for this bundle.
     */
    public function testBuildWithEmptyContainerDoesNotCrash(): void
    {
        $bundle = new CodeFoundationFlowConfigBundle();
        $container = new ContainerBuilder(null);

        $bundle->build($container);

        // Temporarily add assertion to keep tests clean.
        self::addToAssertionCount(1);
    }
}
