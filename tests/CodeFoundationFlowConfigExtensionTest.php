<?php
declare(strict_types=1);

namespace Tests\CodeFoundation\Bundle\FlowConfigBundle\DependencyInjection;

use CodeFoundation\Bundle\FlowConfigBundle\DependencyInjection\CodeFoundationFlowConfigExtension;
use PHPUnit\Framework\TestCase;

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
}