<?php
declare(strict_types = 1);

namespace LarsNieuwenhuizen\ClubhouseConnector\Tests\Unit\Component\Projects\Domain\Model;

use LarsNieuwenhuizen\ClubhouseConnector\Component\Projects\Domain\Model\Project;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Stories\Domain\Model\Story;
use PHPUnit\Framework\TestCase;

final class StoryTest extends TestCase
{

    private array $dummySingleResponse;

    public function setUp(): void
    {
        $json = '{
          "app_url": "foo",
          "archived": true,
          "blocked": true,
          "blocker": true,
          "branches": [{
            "created_at": "2016-12-31T12:30:00Z",
            "deleted": true,
            "entity_type": "foo",
            "id": 123,
            "merged_branch_ids": [123],
            "name": "foo",
            "persistent": true,
            "pull_requests": [{
              "branch_id": 123,
              "branch_name": "foo",
              "closed": true,
              "created_at": "2016-12-31T12:30:00Z",
              "draft": true,
              "entity_type": "foo",
              "id": 123,
              "num_added": 123,
              "num_commits": 123,
              "num_modified": 123,
              "num_removed": 123,
              "number": 123,
              "target_branch_id": 123,
              "target_branch_name": "foo",
              "title": "foo",
              "updated_at": "2016-12-31T12:30:00Z",
              "url": "foo"
            }],
            "repository_id": 123,
            "updated_at": "2016-12-31T12:30:00Z",
            "url": "foo"
          }],
          "comments": [{
            "app_url": "foo",
            "author_id": "12345678-9012-3456-7890-123456789012",
            "created_at": "2016-12-31T12:30:00Z",
            "entity_type": "foo",
            "external_id": "foo",
            "group_mention_ids": ["12345678-9012-3456-7890-123456789012"],
            "id": 123,
            "member_mention_ids": ["12345678-9012-3456-7890-123456789012"],
            "mention_ids": ["12345678-9012-3456-7890-123456789012"],
            "position": 123,
            "story_id": 123,
            "text": "foo",
            "updated_at": "2016-12-31T12:30:00Z"
          }],
          "commits": [{
            "author_email": "foo",
            "author_id": "12345678-9012-3456-7890-123456789012",
            "author_identity": {
              "entity_type": "foo",
              "name": "foo",
              "type": "foo"
            },
            "created_at": "2016-12-31T12:30:00Z",
            "entity_type": "foo",
            "hash": "foo",
            "id": 123,
            "merged_branch_ids": [123],
            "message": "foo",
            "repository_id": 123,
            "timestamp": "2016-12-31T12:30:00Z",
            "updated_at": "2016-12-31T12:30:00Z",
            "url": "foo"
          }],
          "completed": true,
          "completed_at": "2016-12-31T12:30:00Z",
          "completed_at_override": "2016-12-31T12:30:00Z",
          "created_at": "2016-12-31T12:30:00Z",
          "cycle_time": 123,
          "deadline": "2016-12-31T12:30:00Z",
          "description": "foo",
          "entity_type": "foo",
          "epic_id": 123,
          "estimate": 123,
          "external_id": "foo",
          "external_links": [],
          "external_tickets": [{
            "external_id": "foo",
            "external_url": "foo",
            "id": "12345678-9012-3456-7890-123456789012",
            "story_ids": [123]
          }],
          "files": [{
            "content_type": "foo",
            "created_at": "2016-12-31T12:30:00Z",
            "description": "foo",
            "entity_type": "foo",
            "external_id": "foo",
            "filename": "foo",
            "group_mention_ids": ["12345678-9012-3456-7890-123456789012"],
            "id": 123,
            "member_mention_ids": ["12345678-9012-3456-7890-123456789012"],
            "mention_ids": ["12345678-9012-3456-7890-123456789012"],
            "name": "foo",
            "size": 123,
            "story_ids": [123],
            "thumbnail_url": "foo",
            "updated_at": "2016-12-31T12:30:00Z",
            "uploader_id": "12345678-9012-3456-7890-123456789012",
            "url": "foo"
          }],
          "follower_ids": ["12345678-9012-3456-7890-123456789012"],
          "group_mention_ids": ["12345678-9012-3456-7890-123456789012"],
          "id": 123,
          "iteration_id": 123,
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
          "lead_time": 123,
          "linked_files": [{
            "content_type": "foo",
            "created_at": "2016-12-31T12:30:00Z",
            "description": "foo",
            "entity_type": "foo",
            "group_mention_ids": ["12345678-9012-3456-7890-123456789012"],
            "id": 123,
            "member_mention_ids": ["12345678-9012-3456-7890-123456789012"],
            "mention_ids": ["12345678-9012-3456-7890-123456789012"],
            "name": "foo",
            "size": 123,
            "story_ids": [123],
            "thumbnail_url": "foo",
            "type": "foo",
            "updated_at": "2016-12-31T12:30:00Z",
            "uploader_id": "12345678-9012-3456-7890-123456789012",
            "url": "foo"
          }],
          "member_mention_ids": ["12345678-9012-3456-7890-123456789012"],
          "mention_ids": ["12345678-9012-3456-7890-123456789012"],
          "moved_at": "2016-12-31T12:30:00Z",
          "name": "foo",
          "owner_ids": ["12345678-9012-3456-7890-123456789012"],
          "position": 123,
          "previous_iteration_ids": [123],
          "project_id": 123,
          "pull_requests": [{
            "branch_id": 123,
            "branch_name": "foo",
            "closed": true,
            "created_at": "2016-12-31T12:30:00Z",
            "draft": true,
            "entity_type": "foo",
            "id": 123,
            "num_added": 123,
            "num_commits": 123,
            "num_modified": 123,
            "num_removed": 123,
            "number": 123,
            "target_branch_id": 123,
            "target_branch_name": "foo",
            "title": "foo",
            "updated_at": "2016-12-31T12:30:00Z",
            "url": "foo"
          }],
          "requested_by_id": "12345678-9012-3456-7890-123456789012",
          "started": true,
          "started_at": "2016-12-31T12:30:00Z",
          "started_at_override": "2016-12-31T12:30:00Z",
          "stats": {
            "num_related_documents": 123
          },
          "story_links": [{
            "created_at": "2016-12-31T12:30:00Z",
            "entity_type": "foo",
            "id": 123,
            "object_id": 123,
            "subject_id": 123,
            "type": "foo",
            "updated_at": "2016-12-31T12:30:00Z",
            "verb": "foo"
          }],
          "story_type": "foo",
          "tasks": [{
            "complete": true,
            "completed_at": "2016-12-31T12:30:00Z",
            "created_at": "2016-12-31T12:30:00Z",
            "description": "foo",
            "entity_type": "foo",
            "external_id": "foo",
            "group_mention_ids": ["12345678-9012-3456-7890-123456789012"],
            "id": 123,
            "member_mention_ids": ["12345678-9012-3456-7890-123456789012"],
            "mention_ids": ["12345678-9012-3456-7890-123456789012"],
            "owner_ids": ["12345678-9012-3456-7890-123456789012"],
            "position": 123,
            "story_id": 123,
            "updated_at": "2016-12-31T12:30:00Z"
          }],
          "updated_at": "2016-12-31T12:30:00Z",
          "workflow_state_id": 123
        }';
        $this->dummySingleResponse = \json_decode($json, true);
        parent::setUp();
    }

    public function getDummySingleResponse(): array
    {
        return $this->dummySingleResponse;
    }

    public function testStoryCanBeCreatedFromResponse(): void
    {
        $story = Story::createFromResponseData($this->getDummySingleResponse());
        $this->assertInstanceOf(Story::class, $story);
        $this->assertEquals('foo', $story->getAppUrl());
    }

    public function testDateValuesAreDateTimeObjects(): void
    {
        $story = Story::createFromResponseData($this->getDummySingleResponse());
        $this->assertInstanceOf(\DateTime::class, $story->getCreatedAt());
        $this->assertInstanceOf(\DateTime::class, $story->getUpdatedAt());
        $this->assertInstanceOf(\DateTime::class, $story->getStartedAtOverride());
    }
}
