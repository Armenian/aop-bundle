<?php

declare(strict_types=1);

namespace DMP\AopBundle\Aop;

use CG\Proxy\InterceptorLoaderInterface;
use CG\Proxy\MethodInterceptorInterface;
use ReflectionMethod;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Lazy-loading interceptor loader implementation.
 *
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 */
class InterceptorLoader implements InterceptorLoaderInterface
{

    private array $loadedInterceptors = array();

    /**
     * @param ContainerInterface $container
     * @param array<array<string>> $interceptors
     */
    public function __construct(
        private ContainerInterface $container, private array $interceptors)
    {}

    /**
     * @param ReflectionMethod $method
     * @return array|MethodInterceptorInterface[]
     */
    public function loadInterceptors(ReflectionMethod $method): array
    {
        if (!isset($this->interceptors[$method->class][$method->name])) {
            return array();
        }

        if (isset($this->loadedInterceptors[$method->class][$method->name])) {
            return $this->loadedInterceptors[$method->class][$method->name];
        }

        $interceptors = array();
        foreach ($this->interceptors[$method->class][$method->name] as $id) {
            $interceptors[] = $this->container->get($id);
        }

        return $this->loadedInterceptors[$method->class][$method->name] = $interceptors;
    }
}
