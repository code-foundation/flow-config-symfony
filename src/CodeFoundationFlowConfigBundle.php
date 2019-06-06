<?php
declare(strict_types=1);

namespace CodeFoundation\Bundle\FlowConfigBundle;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class CodeFoundationFlowConfigBundle extends Bundle
{
    /**
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        $namespace = 'CodeFoundation\FlowConfig\Entity';
        $mappingDir = $this->getEntityPath() . '/DoctrineMaps';

        $ormCompilerClass = 'Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass';
        if (class_exists($ormCompilerClass)) {
            $arguments = [$mappingDir, '.orm.xml'];
            $namespaceMap = [$namespace];
            $locator   = new Definition('Doctrine\Common\Persistence\Mapping\Driver\DefaultFileLocator', $arguments);
            $driver    = new Definition('Doctrine\ORM\Mapping\Driver\XmlDriver', [$locator]);
            $aliasMap = ['FlowControl' => $namespace];

            $container->addCompilerPass(

                new DoctrineOrmMappingsPass($driver, $namespaceMap, [], false, $aliasMap)
            );
        }
    }

    private function getEntityPath(): string
    {
        $reflector = new \ReflectionClass(\CodeFoundation\FlowConfig\Entity\ConfigItem::class);
        $file = $reflector->getFileName();
        $directory = \realpath(dirname($file));
        return $directory;
    }
}
