<?php
declare(strict_types=1);

namespace Tests\CodeFoundation\Bundle\FlowConfigBundle;

use CodeFoundation\Bundle\FlowConfigBundle\CodeFoundationFlowConfigBundle;
use PHPUnit\Framework\TestCase;

/**
 * @covers \CodeFoundation\Bundle\FlowConfigBundle\CodeFoundationFlowConfigBundle
 */
class CodeFoundationFlowConfigBundleTest extends TestCase
{
    /**
     * Test the alias naming for this bundle.
     */
    public function testX(): void
    {
        $bundle = new CodeFoundationFlowConfigBundle();
    }
}