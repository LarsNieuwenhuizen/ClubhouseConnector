<?php
declare(strict_types = 1);

namespace LarsNieuwenhuizen\ClubhouseConnector\Tests\Unit\Component\Domain\Model;

use LarsNieuwenhuizen\ClubhouseConnector\Component\Domain\Model\ComponentCollection;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Epics\Domain\Model\Epic;
use PHPUnit\Framework\TestCase;

final class ComponentCollectionTest extends TestCase
{

    private ComponentCollection $subject;

    protected function setUp(): void
    {
        $this->subject = new ComponentCollection();
        parent::setUp();
    }

    public function testEpicCollectionCanCollectComponents(): void
    {
        $milestone = new Epic();
        $this->subject->addComponent($milestone);
        $this->assertEquals(1, $this->subject->count());
    }

    public function testEpicCollectionIsIterable(): void
    {
        $this->assertIsIterable($this->subject);
        $milestone = new Epic();
        $this->subject->addComponent($milestone);
        foreach ($this->subject as $item) {
            // nope
        }
    }

    public function testEpicCollectionIsCountable(): void
    {
        $this->assertInstanceOf(\Countable::class, $this->subject);
    }
}
