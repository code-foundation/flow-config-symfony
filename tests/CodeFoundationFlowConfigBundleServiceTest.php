<?php
declare(strict_types=1);

namespace CodeFoundation\Bundle\FlowConfigBundle\Tests;

use CodeFoundation\Bundle\FlowConfigBundle\Tests\Fixtures\BundleTestKernel;
use CodeFoundation\Bundle\FlowConfigBundle\Tests\Stubs\EntityStub;
use CodeFoundation\FlowConfig\Entity\ConfigItem;
use CodeFoundation\FlowConfig\Entity\EntityConfigItem;
use CodeFoundation\FlowConfig\Repository\CascadeConfig;
use CodeFoundation\FlowConfig\Repository\DoctrineConfig;
use CodeFoundation\FlowConfig\Repository\DoctrineEntityConfig;
use CodeFoundation\FlowConfig\Repository\ReadonlyConfig;
use Doctrine\ORM\Tools\SchemaTool;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CodeFoundationFlowConfigBundleServiceTest extends TestCase
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    private $container;

    /**
     * Test the resolution of the correct services from the container.
     */
    public function testGettingServices(): void
    {
        $container = $this->getContainer();

        $readonlyConfigService = $container->get('flowconfig.ro');
        $configService = $container->get('flowconfig.system');
        $entityConfigService = $container->get('flowconfig.entity');
        $cascadeServiceConfig = $container->get('flowconfig.cascade');

        self::assertInstanceOf(ReadonlyConfig::class, $readonlyConfigService);
        self::assertInstanceOf(DoctrineConfig::class, $configService);
        self::assertInstanceOf(DoctrineEntityConfig::class, $entityConfigService);
        self::assertInstanceOf(CascadeConfig::class, $cascadeServiceConfig);
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
        $entity = new EntityStub('user', '888');

        /** @var $configService \CodeFoundation\FlowConfig\Repository\DoctrineEntityConfig */
        $response = $configService->getByEntity($entity, 'key.setting');

        self::assertNull($response);
    }

    /**
     * Test the resolution of ac keys from Entity config.
     */
    public function testDefaults(): void
    {
        $roConfig = $this->getContainer()->get('flowconfig.ro');
        $systemConfig = $this->getContainer()->get('flowconfig.system');
        $entityConfig = $this->getContainer()->get('flowconfig.entity');
        $entity = new EntityStub('user', '123456');

        $roResponse = $roConfig->get('user.email.format');
        $systemResponse = $systemConfig->get('user.email.format');
        $entityResponse = $entityConfig->getByEntity($entity, 'user.email.format');

        self::assertSame('text', $roResponse);
        self::assertNull($systemResponse);
        self::assertNull($entityResponse);
    }

    /**
     * Test the resolution of ac keys from Entity config.
     */
    public function testSystemOverridesDefault(): void
    {
        $roConfig = $this->getContainer()->get('flowconfig.ro');
        $systemConfig = $this->getContainer()->get('flowconfig.system');
        $entityConfig = $this->getContainer()->get('flowconfig.entity');
        $flowConfig = $this->getContainer()->get('flowconfig.cascade');
        $entity = new EntityStub('user', '123456');
        $systemConfig->set('user.email.format', 'html');

        $roResponse = $roConfig->get('user.email.format');
        $systemResponse = $systemConfig->get('user.email.format');
        $entityResponse = $entityConfig->getByEntity($entity, 'user.email.format');
        $flowConfigResponse = $flowConfig->getByEntity($entity, 'user.email.format');

        self::assertSame('text', $roResponse);
        self::assertSame('html', $systemResponse);
        self::assertNull($entityResponse);
        self::assertSame('html', $flowConfigResponse);
    }

    /**
     * Build a configured symfony container.
     *
     * @returns \Symfony\Component\DependencyInjection\ContainerInterface
     */
    private function getContainer(): ContainerInterface
    {
        if ($this->container !== null) {
            return $this->container;
        }

        $kernel = new BundleTestKernel('test', true);
        $kernel->boot();
        $this->container = $kernel->getContainer();
        $entityManager = $this->container->get('doctrine.orm.default_entity_manager');

        $schemaTool = new SchemaTool($entityManager);
        $schemaTool->createSchema([
            $entityManager->getClassMetadata(ConfigItem::class),
            $entityManager->getClassMetadata(EntityConfigItem::class)
        ]);

        return $this->container;
    }
}
