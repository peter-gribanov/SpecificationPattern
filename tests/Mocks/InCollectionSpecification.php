<?php

namespace Mbrevda\SpecificationPattern\Tests\Mocks;

use \Mbrevda\SpecificationPattern\SpecificationInterface;

class InCollectionSpecification implements SpecificationInterface
{
    public function isSatisfiedBy($candidate)
    {
        return $candidate->isInCollection;
    }
}
