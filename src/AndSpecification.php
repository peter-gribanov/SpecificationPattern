<?php

namespace Mbrevda\SpecificationPattern;

class AndSpecification extends CompositeSpecification
{
    private $specifications = [];

    public function __construct(SpecificationInterface $first, SpecificationInterface $second)
    {
        foreach (func_get_args() as $specification) {
            $this->andX($specification);
        }
    }

    public function andX(SpecificationInterface $specification)
    {
        $this->specifications[] = $specification;

        return $this;
    }

    public function isSatisfiedBy($candidate)
    {
        foreach ($this->specifications as $specification) {
            if (!$specification->isSatisfiedBy($candidate)) {
                return false;
            }
        }

        return true;
    }
}
