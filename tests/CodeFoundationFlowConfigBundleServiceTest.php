<?php
declare(strict_types=1);

namespace CodeFoundation\Bundle\FlowConfigBundle\Tests;

use CodeFoundation\Bundle\FlowConfigBundle\Tests\Fixtures\BundleTestKernel;
use CodeFoundation\Bundle\FlowConfigBundle\Tests\Stubs\EntityStub;
use CodeFoundation\FlowConfig\Entity\ConfigItem;
use CodeFoundation\FlowConfig\Entity\EntityConfigItem;
use CodeFoundation\FlowConfig\Repository\CascadeConfig;
use CodeFoundation\FlowConfig\Repository\DoctrineConfig;
use Doctrine\ORM\Tools\SchemaTool;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\Container;

class CodeFoundationFlowConfigBundleServiceTest extends TestCase
{
    /**
     * Test the resolution of the correct services from the container.
     */
    public function testGettingServices(): void
    {
        $container = $this->getContainer();

        $configService = $container->get('flowconfig.system');
        $entityConfigService = $container->get('flowconfig.entity');

        self::assertInstanceOf(DoctrineConfig::class, $configService);
        self::assertInstanceOf(CascadeConfig::class, $entityConfigService);
    }

    /**
     * Test the resolution of null keys from System config.
     */
    public function testEmptyResults(): void
    {
        $configService = $this->getContainer()->get('flowconfig.system');

        /** @var $configService \CodeFoundation\FlowConfig\Repository\DoctrineConfig */
        $response = $configService->get('abc');

        self::assertNull($response);
    }

    /**
     * Test the resolution of null keys from Entity config.
     */
    public function testEmptyResultsEntity(): void
    {
        $configService = $this->getContainer()->get('flowconfig.entity');
        $entity = new EntityStub('user','888');

        /** @var $configService \CodeFoundation\FlowConfig\Repository\DoctrineEntityConfig */
        $response = $configService->getByEntity($entity, 'key.setting');

        self::assertNull($response);
    }

    /**
     * Test the resolution of null keys from Entity config.
     */
    public function testDefaults(): void
    {
        $systemConfig = $this->getContainer()->get('flowconfig.system');
        $entityConfig = $this->getContainer()->get('flowconfig.entity');
        $entity = new EntityStub('user','123456');

        $systemResponse = $systemConfig->get('user.email.format');
        $entityResponse = $entityConfig->getByEntity($entity, 'user.email.format');

        self::assertSame('text', $systemResponse);
        self::assertSame('text', $entityResponse);
    }

    /**
     * Build a configured symfony container.
     *
     * @returns \Symfony\Component\DependencyInjection\Container
     */
    private function getContainer(): Container
    {
        $kernel = new BundleTestKernel('test', true);
        $kernel->boot();
        $container = $kernel->getContainer();
        $entityManager = $container->get('doctrine.orm.default_entity_manager');

        $schemaTool = new SchemaTool($entityManager);
        $schemaTool->createSchema([
            $entityManager->getClassMetadata(ConfigItem::class),
            $entityManager->getClassMetadata(EntityConfigItem::class)
        ]);

        return $container;
    }
}
