<?php

/*
 * Copyright 2011 Johannes M. Schmitt <schmittjoh@gmail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace DMP\AopBundle\Tests\DependencyInjection\Compiler\Fixture;

use DMP\AopBundle\Aop\PointcutInterface;
use ReflectionClass;
use ReflectionMethod;

class LoggingPointcut implements PointcutInterface
{
    /**
     * @param ReflectionClass $class
     * @return bool
     */
    public function matchesClass(ReflectionClass $class): bool
    {
        return true;
    }

    /**
     * @param ReflectionMethod $method
     * @return bool
     */
    public function matchesMethod(ReflectionMethod $method): bool
    {
        return false !== strpos($method->name, 'delete')
            || false !== strpos($method->name, 'optional')
            || false !== strpos($method->name, 'nothing');
    }
}
