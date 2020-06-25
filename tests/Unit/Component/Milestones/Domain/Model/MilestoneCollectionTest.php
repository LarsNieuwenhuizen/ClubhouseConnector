<?php
declare(strict_types = 1);

namespace LarsNieuwenhuizen\ClubhouseConnector\Tests\Unit\Component\Milestones\Domain\Model;

use LarsNieuwenhuizen\ClubhouseConnector\Component\Milestones\Domain\Model\Milestone;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Milestones\Domain\Model\MilestoneCollection;
use PHPUnit\Framework\TestCase;

final class MilestoneCollectionTest extends TestCase
{

    private MilestoneCollection $subject;

    protected function setUp(): void
    {
        $this->subject = new MilestoneCollection();
        parent::setUp();
    }

    public function testEpicCollectionCanCollectEpics(): void
    {
        $milestone = new Milestone();
        $this->subject->addMilestone($milestone);
        $this->assertEquals(1, $this->subject->count());
    }

    public function testEpicCollectionIsIterable(): void
    {
        $this->assertIsIterable($this->subject);
        $milestone = new Milestone();
        $this->subject->addMilestone($milestone);
        foreach ($this->subject as $item) {
            // nope
        }
    }

    public function testEpicCollectionIsCountable(): void
    {
        $this->assertInstanceOf(\Countable::class, $this->subject);
    }
}
