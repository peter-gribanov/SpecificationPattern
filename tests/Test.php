<?php

namespace Mbrevda\SpecificationPattern\Tests;

use Mbrevda\SpecificationPattern\AndSpecification;
use Mbrevda\SpecificationPattern\NotSpecification;
use Mbrevda\SpecificationPattern\OrSpecification;
use Mbrevda\SpecificationPattern\Tests\Mocks\OverDueSpecification;
use Mbrevda\SpecificationPattern\Tests\Mocks\NoticeNotSentSpecification;
use Mbrevda\SpecificationPattern\Tests\Mocks\InCollectionSpecification;

class Tests extends \PHPUnit_Framework_TestCase
{
    private $invoices;
    private $overDue;
    private $noticeNotSent;
    private $inCollection;

    public function setUp()
    {
        $this->invoices       = json_decode(file_get_contents(__DIR__ . '/db.json'));
        $this->overDue        = new OverDueSpecification(time());
        $this->noticeNotSent  = new NoticeNotSentSpecification();
        $this->inCollection   = new InCollectionSpecification();
    }

    public function usingSpec($spec)
    {
        $res = [];
        foreach ($this->invoices as $invoice) {
            if ($spec->isSatisfiedBy($invoice)) {
                $res[] = $invoice;
            }
        }

        return $res;
    }

    public function testOverDueSpecification(){
        self::assertFalse($this->overDue->isSatisfiedBy($this->invoices[0]));
        self::assertTrue($this->overDue->isSatisfiedBy($this->invoices[1]));
        self::assertTrue($this->overDue->isSatisfiedBy($this->invoices[2]));
        self::assertTrue($this->overDue->isSatisfiedBy($this->invoices[3]));
    }

    public function testNoticeSentSpecification(){
        self::assertTrue($this->noticeNotSent->isSatisfiedBy($this->invoices[0]));
        self::assertTrue($this->noticeNotSent->isSatisfiedBy($this->invoices[1]));
        self::assertFalse($this->noticeNotSent->isSatisfiedBy($this->invoices[2]));
        self::assertTrue($this->noticeNotSent->isSatisfiedBy($this->invoices[3]));
    }

    public function testInCollectionSpecification(){
        self::assertFalse($this->inCollection->isSatisfiedBy($this->invoices[0]));
        self::assertTrue($this->inCollection->isSatisfiedBy($this->invoices[1]));
        self::assertFalse($this->inCollection->isSatisfiedBy($this->invoices[2]));
        self::assertFalse($this->inCollection->isSatisfiedBy($this->invoices[3]));
    }

    public function testAndX()
    {
        $spec1 = $this->overDue->andX($this->noticeNotSent);
        $spec2 = new AndSpecification($this->overDue, $this->noticeNotSent);

        self::assertCount(2, $this->usingSpec($spec1));
        self::assertCount(2, $this->usingSpec($spec2));
    }

    public function testAndXandNot()
    {
        $spec1 = $this->overDue->andX($this->noticeNotSent)->not();
        $spec2 = new NotSpecification(
            new AndSpecification($this->overDue, $this->noticeNotSent)
        );

        self::assertCount(2, $this->usingSpec($spec1));
        self::assertCount(2, $this->usingSpec($spec2));
    }

    public function testAndandNot()
    {
        $spec1 = $this->overDue->andX($this->noticeNotSent)->not();
        $spec2 = new NotSpecification(
            new AndSpecification($this->overDue, $this->noticeNotSent)
        );

        self::assertCount(2, $this->usingSpec($spec1));
        self::assertCount(2, $this->usingSpec($spec2));
    }

    public function testOr()
    {
        $spec1 = $this->overDue->orX(new NotSpecification($this->overDue));
        $spec2 = new OrSpecification($this->overDue, new NotSpecification($this->overDue));

        self::assertCount(4, $this->usingSpec($spec1));
        self::assertCount(4, $this->usingSpec($spec2));
    }
}
