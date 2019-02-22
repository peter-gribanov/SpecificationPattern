<?php

namespace Mbrevda\SpecificationPattern;

class OrSpecification extends CompositeSpecification
{
    private $specifications = [];

    public function __construct(SpecificationInterface $first, SpecificationInterface $second)
    {
        foreach (func_get_args() as $specification) {
            $this->orX($specification);
        }
    }

    public function orX(SpecificationInterface $specification)
    {
        $this->specifications[] = $specification;

        return $this;
    }

    public function isSatisfiedBy($candidate)
    {
        foreach ($this->specifications as $specification) {
            if ($specification->isSatisfiedBy($candidate)) {
                return true;
            }
        }

        return false;
    }
}
