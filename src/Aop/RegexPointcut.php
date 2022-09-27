<?php

declare(strict_types=1);

namespace DMP\AopBundle\Aop;

use ReflectionClass;
use ReflectionMethod;

/**
 * A regex pointcut implementation.
 *
 * Uses a regular expression for determining whether the pointcut matches.
 *
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 */
class RegexPointcut implements PointcutInterface
{

    public function __construct(private string $pattern)
    {}

    public function matchesClass(ReflectionClass $class): bool
    {
        return true;
    }

    public function matchesMethod(ReflectionMethod $method): bool
    {
        return 0 < preg_match('#' . $this->pattern . '#', sprintf('%s::%s', $method->class, $method->name));
    }
}
