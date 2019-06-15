<?php
declare(strict_types=1);

namespace CodeFoundation\Bundle\FlowConfigBundle\Tests\DependencyInjection;

use CodeFoundation\Bundle\FlowConfigBundle\DependencyInjection\CodeFoundationFlowConfigExtension;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @covers CodeFoundationFlowConfigExtension
 */
class CodeFoundationFlowConfigExtensionTest extends TestCase
{
    /**
     * Test the alias naming for this bundle.
     */
    public function testAlias(): void
    {
        $extension = new CodeFoundationFlowConfigExtension();

        self::assertSame('flow_config', $extension->getAlias());
    }

    /**
     * Test configurations are loaded.
     */
    public function testDefaultConfig(): void
    {
        $extension = new CodeFoundationFlowConfigExtension();

        $container = new ContainerBuilder(null);
        $extension->load([], $container);

        $configs = $extension->getProcessedConfigs();

        self::assertSame([['defaults' => [] ]], $configs);
    }

    /**
     * Test configurations are loaded.
     */
    public function testOverriddenDefaults(): void
    {
        $extension = new CodeFoundationFlowConfigExtension();

        $container = new ContainerBuilder(null);
        $extension->load(['flow_config' => ['defaults' => ['abc' => '123', 'some.other' => true]]], $container);

        $configs = $extension->getProcessedConfigs();

        self::assertSame([['defaults' => ['abc' => '123', 'some.other' => true]]], $configs);
    }
}
