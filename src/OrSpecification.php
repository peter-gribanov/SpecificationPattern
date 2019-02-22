<?php

namespace Mbrevda\SpecificationPattern;

class OrSpecification implements SpecificationInterface
{
    private $one;
    private $other;

    public function __construct(
        SpecificationInterface $one,
        SpecificationInterface $other
    ) {
        $this->one = $one;
        $this->other = $other;
    }

    public function isSatisfiedBy($candidate)
    {
        return $this->one->isSatisfiedBy($candidate)
            || $this->other->isSatisfiedBy($candidate);
    }
}
