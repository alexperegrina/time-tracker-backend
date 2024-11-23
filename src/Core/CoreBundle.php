<?php
declare(strict_types=1);

namespace DegustaBox\Core;

use DegustaBox\Core\DependencyInjection\CoreExtension;
use DegustaBox\Core\Infrastructure\Symfony\CompilerPass\RemoveTagKernelResetCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class CoreBundle extends Bundle
{
    protected function getContainerExtensionClass(): string
    {
        return CoreExtension::class;
    }

    public function build(ContainerBuilder $container): void
    {
        parent::build($container);
        $container->addCompilerPass(new RemoveTagKernelResetCompilerPass());
    }
}