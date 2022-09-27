<?php

declare(strict_types=1);

namespace DMP\AopBundle\Aop;

final class PointcutContainer
{

    /**
     * @param array<PointcutInterface> $pointcuts
     */
    public function __construct(private array $pointcuts)
    {}

    public function getPointcuts(): array
    {
        return $this->pointcuts;
    }
}
