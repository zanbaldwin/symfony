<?php declare(strict_types=1);

namespace Symfony\Bundle\FrameworkBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\Yaml\Parser;

class YamlTransformerPass implements CompilerPassInterface
{
    private const YAML_SERVICE_ID = 'yaml.parser';

    /** {@inheritdoc} */
    public function process(ContainerBuilder $container): void
    {
        if (!$container->hasDefinition(self::YAML_SERVICE_ID)) {
            return;
        }
        $definition = $container->getDefinition(self::YAML_SERVICE_ID);
        if (!$container->hasAlias(Parser::class)) {
            $container->setAlias(Parser::class, 'yaml.parser');
        }
        foreach ($container->findTaggedServiceIds('yaml.transformer', true) as $id => $attributes) {
            foreach ($attributes as $tag) {
                $definition->addMethodCall('addTransformer', [new Reference($id), $tag['priority'] ?? 0]);
            }
        }
    }
}