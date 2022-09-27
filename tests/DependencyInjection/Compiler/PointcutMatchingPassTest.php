<?php

declare(strict_types=1);

namespace DMP\AopBundle\Tests\DependencyInjection\Compiler;

use Exception;
use DMP\AopBundle\DependencyInjection\Compiler\PointcutMatchingPass;
use DMP\AopBundle\DependencyInjection\AopExtension;
use DMP\AopBundle\Tests\DependencyInjection\Compiler\Fixture\LoggingInterceptor;
use DMP\AopBundle\Tests\DependencyInjection\Compiler\Fixture\LoggingPointcut;
use DMP\AopBundle\Tests\DependencyInjection\Compiler\Fixture\TestService;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use Symfony\Component\DependencyInjection\Compiler\ResolveParameterPlaceHoldersPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Filesystem\Filesystem;

class PointcutMatchingPassTest extends TestCase
{
    private string $cacheDir;
    private Filesystem $fs;

    /**
     * @throws ReflectionException
     * @throws Exception
     */
    public function testProcess()
    {
        $container = $this->getContainer();

        $container
            ->register('pointcut', LoggingPointcut::class)
            ->addTag('jms_aop.pointcut', array('interceptor' => 'interceptor'));
        $container
            ->register('interceptor', LoggingInterceptor::class);
        $container
            ->register('test', TestService::class);

        $this->process($container);

        /** @var TestService $service */
        $service = $container->get('test');
        $this->assertInstanceOf(TestService::class, $service);
        $this->assertTrue($service->add());
        $this->assertTrue($service->delete());
        $this->assertNull($service->optional());
        $service->nothing();
        $this->assertEquals([
            'delete',
            'optional',
            'nothing',
        ], $container->get('interceptor')->getLog());
    }

    protected function setUp(): void
    {
        $this->cacheDir = sys_get_temp_dir() . '/jms_aop_test';
        $this->fs = new Filesystem();

        if (is_dir($this->cacheDir)) {
            $this->fs->remove($this->cacheDir);
        }

        $this->fs->mkdir($this->cacheDir, 0777);
    }

    protected function tearDown(): void
    {
        $this->fs->remove($this->cacheDir);
    }

    /**
     * @return ContainerBuilder
     * @throws Exception
     */
    private function getContainer(): ContainerBuilder
    {
        $container = new ContainerBuilder();

        $extension = new AopExtension();
        $extension->load([[
            'cache_dir' => $this->cacheDir,
        ]], $container);

        return $container;
    }

    /**
     * @param ContainerBuilder $container
     * @throws ReflectionException
     */
    private function process(ContainerBuilder $container): void
    {
        $pass = new ResolveParameterPlaceHoldersPass();
        $pass->process($container);

        $pass = new PointcutMatchingPass();
        $pass->process($container);
    }
}
