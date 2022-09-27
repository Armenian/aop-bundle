<?php

declare(strict_types=1);

namespace DMP\AopBundle\Aop;

use ReflectionClass;
use ReflectionMethod;

/**
 * Pointcut Interface.
 *
 * Implementations of this class are responsible for making a decision on whether
 * a certain method call matches the advice which is associated with this pointcut.
 *
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 */
interface PointcutInterface
{
    /**
     * Determines whether the advice applies to instances of the given class.
     *
     * There are some limits as to what you can do in this method. Namely, you may
     * only base your decision on resources that are part of the ContainerBuilder.
     * Specifically, you may not use any data in the class itself, such as
     * annotations.
     *
     * @param ReflectionClass $class
     * @return boolean
     */
    public function matchesClass(ReflectionClass $class): bool;

    /**
     * Determines whether the advice applies to the given method.
     *
     * This method is not limited in the way the matchesClass method is. It may
     * use information in the associated class to make its decision.
     *
     * @param ReflectionMethod $method
     * @return boolean
     */
    public function matchesMethod(ReflectionMethod $method): bool;
}
