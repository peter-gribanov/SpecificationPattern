<?php

namespace Mbrevda\SpecificationPattern\Tests\Mocks;

use \Mbrevda\SpecificationPattern\SpecificationInterface;

class NoticeNotSentSpecification implements SpecificationInterface
{
    public function isSatisfiedBy($candidate)
    {
        return $candidate->hasSentNotice == false;
    }
}
