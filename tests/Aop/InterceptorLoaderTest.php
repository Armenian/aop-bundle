<?php

declare(strict_types=1);

namespace DMP\AopBundle\Tests\Aop;

use CG\Proxy\MethodInterceptorInterface;
use DMP\AopBundle\Aop\InterceptorLoader;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use ReflectionMethod;
use Symfony\Component\DependencyInjection\ContainerInterface;

class InterceptorLoaderTest extends TestCase
{
    public function testLoadInterceptors()
    {
        /** @var MockObject|MethodInterceptorInterface $interceptor */
        $interceptor = $this->getMockBuilder('CG\Proxy\MethodInterceptorInterface')->getMock();

        list($loader, $container) = $this->getLoader(array(
            'DMP\AopBundle\Tests\Aop\InterceptorLoaderTestClass' => array(
                'foo' => array('foo'),
            ),
        ));

        $container
            ->expects($this->once())
            ->method('get')
            ->with($this->equalTo('foo'))
            ->will($this->returnValue($interceptor));

        $method = new ReflectionMethod('DMP\AopBundle\Tests\Aop\InterceptorLoaderTestClass', 'foo');

        $this->assertSame(array($interceptor), $loader->loadInterceptors($method));
        // yes, twice
        $this->assertSame(array($interceptor), $loader->loadInterceptors($method));
    }

    private function getLoader(array $interceptors = array())
    {
        /** @var MockObject|ContainerInterface  $container */
        $container = $this->getMockBuilder('Symfony\Component\DependencyInjection\ContainerInterface')->getMock();

        return array(new InterceptorLoader($container, $interceptors), $container);
    }
}

class InterceptorLoaderTestClass
{
    public function foo()
    {
    }
}
