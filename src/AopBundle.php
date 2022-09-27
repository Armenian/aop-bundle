<?php

declare(strict_types=1);

namespace DMP\AopBundle;

use DMP\AopBundle\DependencyInjection\Compiler\PointcutMatchingPass;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AopBundle extends Bundle
{

    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new PointcutMatchingPass(), PassConfig::TYPE_AFTER_REMOVING);
    }
}
