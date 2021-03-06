<?php
declare(strict_types=1);

namespace CodeFoundation\FlowConfigBundle\Tests;

use CodeFoundation\FlowConfigBundle\FlowConfigBundle;
use CodeFoundation\FlowConfigBundle\Tests\Fixtures\BundleTestKernel;
use CodeFoundation\FlowConfig\Entity\ConfigItem;
use CodeFoundation\FlowConfig\Entity\EntityConfigItem;
use Doctrine\ORM\Tools\SchemaTool;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @covers \CodeFoundation\FlowConfigBundle\FlowConfigBundle
 */
class FlowConfigBundleTest extends TestCase
{
    /**
     * Test the alias naming for this bundle.
     */
    public function testBuildWithEmptyContainerDoesNotCrash(): void
    {
        $bundle = new FlowConfigBundle();
        $container = new ContainerBuilder(null);

        $bundle->build($container);

        // Temporarily add assertion to keep tests clean.
        self::addToAssertionCount(1);
    }

    /**
     * Test that the bundle can build working entities.
     *
     * @throws \Doctrine\ORM\Tools\ToolsException
     */
    public function testEntityLists(): void
    {
        $kernel = new BundleTestKernel('test', true);
        $kernel->boot();
        $container = $kernel->getContainer();
        /** @var \Doctrine\ORM\EntityManager $entityManager */
        $entityManager = $container->get('doctrine.orm.default_entity_manager');

        $configItemData = $entityManager->getClassMetadata(ConfigItem::class);
        $entityConfigItemData = $entityManager->getClassMetadata(EntityConfigItem::class);

        $schemaTool = new SchemaTool($entityManager);
        $schemaTool->createSchema([$configItemData, $entityConfigItemData]);

        self::addToAssertionCount(1);
    }
}
