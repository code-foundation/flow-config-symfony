<?php
declare(strict_types=1);

namespace CodeFoundation\Bundle\FlowConfigBundle;

use CodeFoundation\Bundle\FlowConfigBundle\DependencyInjection\FlowConfigExtension;
use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class FlowConfigBundle extends Bundle
{
    /**
     * Configure Flow Config Symfony bundle.
     *
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        $ormCompilerClass = 'Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass';
        if (class_exists($ormCompilerClass)) {
            $this->addDoctrineMappings($container);
        }
    }

    /**
     * Add FlowConfig Entities to default Entity Manager.
     *
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    private function addDoctrineMappings(ContainerBuilder $container): void
    {
        $baseClass = \CodeFoundation\FlowConfig\Entity\ConfigItem::class;
        $namespace = 'CodeFoundation\FlowConfig\Entity';

        $mappingDir = $this->getEntityPath($baseClass) . '/DoctrineMaps';

        $namespaceMap = [$namespace];
        $locator = new Definition(
            'Doctrine\Common\Persistence\Mapping\Driver\DefaultFileLocator',
            [$mappingDir, '.orm.xml']
        );
        $driver = new Definition(
            'Doctrine\ORM\Mapping\Driver\XmlDriver',
            [$locator]
        );
        $aliasMap = ['FlowControl' => $namespace];

        $container->addCompilerPass(
            new DoctrineOrmMappingsPass(
                $driver,
                $namespaceMap,
                [],
                false,
                $aliasMap
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getContainerExtension()
    {
        return new FlowConfigExtension();
    }

    /**
     * Get the full system path to the directory of the supplied class.
     *
     * @param string $class
     *
     * @return string
     *
     * @throws \ReflectionException
     */
    private function getEntityPath(string $class): string
    {
        $reflector = new \ReflectionClass($class);
        $file = $reflector->getFileName();
        $directory = \realpath(dirname($file));
        return $directory;
    }
}
