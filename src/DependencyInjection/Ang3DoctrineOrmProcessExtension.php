<?php

namespace Ang3\Bundle\DoctrineOrmProcessBundle\DependencyInjection;

use Ang3\Component\Doctrine\ORM\BatchProcessor;
use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Configuration;
use Exception;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;

class Ang3DoctrineOrmProcessExtension extends Extension implements PrependExtensionInterface
{
    /**
     * @throws Exception on services loading failure
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yaml');
    }

    public function prepend(ContainerBuilder $container): void
    {
        $this->loadBatchProcessors($container);
    }

    /**
     * @internal
     */
    private function loadBatchProcessors(ContainerBuilder $container): void
    {
        $configs = $container->getExtensionConfig('doctrine');
        $config = $this->processConfiguration(new Configuration($container->getParameter('kernel.debug')), $configs);
        $managerNames = array_keys($config['orm']['entity_managers']);

        foreach ($managerNames as $managerName) {
            $managerId = sprintf('doctrine.orm.%s_entity_manager', $managerName);
            $managerReference = new Reference($managerId);

            $batchProcessor = new Definition(BatchProcessor::class, [$managerReference]);
            $batchProcessorId = sprintf('ang3_doctrine_orm_process.%s', $managerName);
            $container->setDefinition($batchProcessorId, $batchProcessor);
            $container->registerAliasForArgument($batchProcessorId, BatchProcessor::class, sprintf('%sBatchProcessor', $managerName));

            if ('default' === $managerName) {
                $container->setDefinition(BatchProcessor::class, $batchProcessor);
            }
        }
    }
}
