<?php
declare(strict_types = 1);

namespace LarsNieuwenhuizen\ClubhouseConnector\Tests\Unit\Component\Epics\Domain\Model;

use LarsNieuwenhuizen\ClubhouseConnector\Component\Epics\Domain\Model\Epic;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Epics\Domain\Model\EpicCollection;
use PHPUnit\Framework\TestCase;

final class EpicCollectionTest extends TestCase
{

    private EpicCollection $subject;

    protected function setUp(): void
    {
        $this->subject = new EpicCollection();
        parent::setUp();
    }

    public function testEpicCollectionCanCollectEpics(): void
    {
        $epic = new Epic();
        $this->subject->addEpic($epic);
        $this->assertEquals(1, $this->subject->count());
    }

    public function testEpicCollectionIsIterable(): void
    {
        $this->assertIsIterable($this->subject);
        $epic = new Epic();
        $this->subject->addEpic($epic);
        foreach ($this->subject as $item) {
            // nope
        }
    }

    public function testEpicCollectionIsCountable(): void
    {
        $this->assertInstanceOf(\Countable::class, $this->subject);
    }
}
