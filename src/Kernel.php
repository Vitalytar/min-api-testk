<?php

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class Kernel extends BaseKernel implements CompilerPassInterface
{
    use MicroKernelTrait;

    /**
     * @param ContainerBuilder $container
     *
     * @return void
     */
    public function process(ContainerBuilder $container): void
    {
        if ($this->environment === 'test') {
            $container->getDefinition('doctrine')->clearTag('kernel.reset');
        }
    }
}
