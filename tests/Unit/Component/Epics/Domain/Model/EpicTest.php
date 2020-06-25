<?php
declare(strict_types = 1);

namespace LarsNieuwenhuizen\ClubhouseConnector\Tests\Unit\Component\Epics\Domain\Model;

use LarsNieuwenhuizen\ClubhouseConnector\Component\Epics\Domain\Model\Epic;
use PHPUnit\Framework\TestCase;

class EpicTest extends TestCase
{

    private array $dummySingleResponse;

    public function setUp(): void
    {
        $json = '{
          "app_url": "foo",
          "archived": true,
          "comments": [{
            "app_url": "foo",
            "author_id": "12345678-9012-3456-7890-123456789012",
            "created_at": "2016-12-31T12:30:00Z",
            "deleted": true,
            "entity_type": "foo",
            "external_id": "foo",
            "group_mention_ids": ["12345678-9012-3456-7890-123456789012"],
            "id": 123,
            "member_mention_ids": ["12345678-9012-3456-7890-123456789012"],
            "mention_ids": ["12345678-9012-3456-7890-123456789012"],
            "text": "foo",
            "updated_at": "2016-12-31T12:30:00Z"
          }],
          "completed": true,
          "completed_at": "2016-12-31T12:30:00Z",
          "completed_at_override": "2016-12-31T12:30:00Z",
          "created_at": "2016-12-31T12:30:00Z",
          "deadline": "2016-12-31T12:30:00Z",
          "description": "foo",
          "entity_type": "foo",
          "epic_state_id": 123,
          "external_id": "foo",
          "external_tickets": [{
            "external_id": "foo",
            "external_url": "foo",
            "id": "12345678-9012-3456-7890-123456789012",
            "story_ids": [123]
          }],
          "follower_ids": ["12345678-9012-3456-7890-123456789012"],
          "group_mention_ids": ["12345678-9012-3456-7890-123456789012"],
          "id": 123,
          "labels": [{
            "app_url": "foo",
            "archived": true,
            "color": "foo",
            "created_at": "2016-12-31T12:30:00Z",
            "description": "foo",
            "entity_type": "foo",
            "external_id": "foo",
            "id": 123,
            "name": "foo",
            "stats": {
              "num_epics": 123,
              "num_points_completed": 123,
              "num_points_in_progress": 123,
              "num_points_total": 123,
              "num_related_documents": 123,
              "num_stories_completed": 123,
              "num_stories_in_progress": 123,
              "num_stories_total": 123,
              "num_stories_unestimated": 123
            },
            "updated_at": "2016-12-31T12:30:00Z"
          }],
          "member_mention_ids": ["12345678-9012-3456-7890-123456789012"],
          "mention_ids": ["12345678-9012-3456-7890-123456789012"],
          "milestone_id": 123,
          "name": "foo",
          "owner_ids": ["12345678-9012-3456-7890-123456789012"],
          "planned_start_date": "2016-12-31T12:30:00Z",
          "position": 123,
          "project_ids": [123],
          "requested_by_id": "12345678-9012-3456-7890-123456789012",
          "started": true,
          "started_at": "2016-12-31T12:30:00Z",
          "started_at_override": "2016-12-31T12:30:00Z",
          "state": "foo",
          "stats": {
            "average_cycle_time": 123,
            "average_lead_time": 123,
            "last_story_update": "2016-12-31T12:30:00Z",
            "num_points": 123,
            "num_points_done": 123,
            "num_points_started": 123,
            "num_points_unstarted": 123,
            "num_related_documents": 123,
            "num_stories_done": 123,
            "num_stories_started": 123,
            "num_stories_unestimated": 123,
            "num_stories_unstarted": 123
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

    public function testEpicCanBeCreatedFromResponse(): void
    {
        $epic = Epic::createFromResponseData($this->getDummySingleResponse());
        $this->assertInstanceOf(Epic::class, $epic);
        $this->assertEquals('foo', $epic->getAppUrl());
    }

    public function testDateValuesAreDateTimeObjects(): void
    {
        $epic = Epic::createFromResponseData($this->getDummySingleResponse());
        $this->assertInstanceOf(\DateTime::class, $epic->getCreatedAt());
        $this->assertInstanceOf(\DateTime::class, $epic->getCompletedAt());
        $this->assertInstanceOf(\DateTime::class, $epic->getCompletedAtOverride());
        $this->assertInstanceOf(\DateTime::class, $epic->getDeadline());
        $this->assertInstanceOf(\DateTime::class, $epic->getPlannedStartDate());
        $this->assertInstanceOf(\DateTime::class, $epic->getStartedAt());
        $this->assertInstanceOf(\DateTime::class, $epic->getStartedAtOverride());
    }
}