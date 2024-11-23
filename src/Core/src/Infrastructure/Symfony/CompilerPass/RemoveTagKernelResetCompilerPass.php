<?php
declare(strict_types=1);

namespace DegustaBox\Core\Infrastructure\Symfony\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class RemoveTagKernelResetCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if ('test' === $container->getParameter('kernel.environment')) {
            // prevents the security token to be cleared
            $container->getDefinition('security.token_storage')->clearTag('kernel.reset');

            // prevents Doctrine entities to be detached
            $container->getDefinition('doctrine')->clearTag('kernel.reset');
        }
    }
}