<?php

declare(strict_types=1);

namespace DMP\AopBundle\Tests\Aop;

use DMP\AopBundle\Aop\RegexPointcut;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionMethod;

class RegexPointcutTest extends TestCase
{
    public function testMatchesClass()
    {
        $pointcut = new RegexPointcut('');
        $this->assertTrue($pointcut->matchesClass(new ReflectionClass('stdClass')));
    }

    public function testMatchesMethod()
    {
        $pointcut = new RegexPointcut('foo$');

        $method = new ReflectionMethod('DMP\AopBundle\Tests\Aop\RegexPointcutTestClass', 'foo');
        $this->assertTrue($pointcut->matchesMethod($method));

        $method = new ReflectionMethod('DMP\AopBundle\Tests\Aop\RegexPointcutTestClass', 'bar');
        $this->assertFalse($pointcut->matchesMethod($method));
    }
}

class RegexPointcutTestClass
{
    public function foo()
    {
    }

    public function bar()
    {
    }
}
