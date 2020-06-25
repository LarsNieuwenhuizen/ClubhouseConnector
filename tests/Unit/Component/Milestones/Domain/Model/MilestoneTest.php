<?php
declare(strict_types = 1);

namespace LarsNieuwenhuizen\ClubhouseConnector\Tests\Unit\Component\Milestones\Domain\Model;

use LarsNieuwenhuizen\ClubhouseConnector\Component\Milestones\Domain\Model\Milestone;
use PHPUnit\Framework\TestCase;

final class MilestoneTest extends TestCase
{

    private array $dummySingleResponse;

    public function setUp(): void
    {
        $json = '{
          "app_url": "foo",
          "categories": [{
            "archived": true,
            "color": "foo",
            "created_at": "2016-12-31T12:30:00Z",
            "entity_type": "foo",
            "external_id": "foo",
            "id": 123,
            "name": "foo",
            "type": "foo",
            "updated_at": "2016-12-31T12:30:00Z"
          }],
          "completed": true,
          "completed_at": "2016-12-31T12:30:00Z",
          "completed_at_override": "2016-12-31T12:30:00Z",
          "created_at": "2016-12-31T12:30:00Z",
          "description": "foo",
          "entity_type": "foo",
          "id": 123,
          "name": "foo",
          "position": 123,
          "started": true,
          "started_at": "2016-12-31T12:30:00Z",
          "started_at_override": "2016-12-31T12:30:00Z",
          "state": "foo",
          "stats": {
            "average_cycle_time": 123,
            "average_lead_time": 123,
            "num_related_documents": 123
          },
          "updated_at": "2016-12-31T12:30:00Z"
        }';
        $this->dummySingleResponse = \json_decode($json, true);
        parent::setUp();
    }

    public function getDummySingleResponse(): array
    {
        return $this->dummySingleResponse;
    }

    public function testMilestoneCanBeCreatedFromResponse(): void
    {
        $milestone = Milestone::createFromResponseData($this->getDummySingleResponse());
        $this->assertInstanceOf(Milestone::class, $milestone);
        $this->assertEquals('foo', $milestone->getAppUrl());
    }

    public function testDateValuesAreDateTimeObjects(): void
    {
        $milestone = Milestone::createFromResponseData($this->getDummySingleResponse());
        $this->assertInstanceOf(\DateTime::class, $milestone->getCreatedAt());
        $this->assertInstanceOf(\DateTime::class, $milestone->getUpdatedAt());
        $this->assertInstanceOf(\DateTime::class, $milestone->getCompletedAt());
        $this->assertInstanceOf(\DateTime::class, $milestone->getCompletedAtOverride());
        $this->assertInstanceOf(\DateTime::class, $milestone->getStartedAt());
        $this->assertInstanceOf(\DateTime::class, $milestone->getStartedAtOverride());
    }
}
