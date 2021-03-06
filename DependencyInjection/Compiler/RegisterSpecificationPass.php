<?php

namespace Strontium\SpecificationBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class RegisterSpecificationPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $registry = $container->getDefinition('strontium.specification.registry');

        foreach ($container->findTaggedServiceIds('specification') as $id => $attributes) {
            if (!isset($attributes[0]['alias'])) {
                throw new \InvalidArgumentException('Tagged specification must have `alias` attribute.');
            }
            $registry->addMethodCall('register', array($attributes[0]['alias'], new Reference($id)));
        }
    }
}
