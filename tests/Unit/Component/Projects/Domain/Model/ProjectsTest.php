<?php
declare(strict_types = 1);

namespace LarsNieuwenhuizen\ClubhouseConnector\Tests\Unit\Component\Projects\Domain\Model;

use LarsNieuwenhuizen\ClubhouseConnector\Component\Projects\Domain\Model\Project;
use PHPUnit\Framework\TestCase;

final class ProjectsTest extends TestCase
{

    private array $dummySingleResponse;

    public function setUp(): void
    {
        $json = '{
          "abbreviation": "foo",
          "app_url": "foo",
          "archived": true,
          "color": "foo",
          "created_at": "2016-12-31T12:30:00Z",
          "days_to_thermometer": 123,
          "description": "foo",
          "entity_type": "foo",
          "external_id": "foo",
          "follower_ids": ["12345678-9012-3456-7890-123456789012"],
          "id": 123,
          "iteration_length": 123,
          "name": "foo",
          "show_thermometer": true,
          "start_time": "2016-12-31T12:30:00Z",
          "stats": {
            "num_points": 123,
            "num_related_documents": 123,
            "num_stories": 123
          },
          "team_id": 123,
          "updated_at": "2016-12-31T12:30:00Z"
        }';
        $this->dummySingleResponse = \json_decode($json, true);
        parent::setUp();
    }

    public function getDummySingleResponse(): array
    {
        return $this->dummySingleResponse;
    }

    public function testProjectCanBeCreatedFromResponse(): void
    {
        $project = Project::createFromResponseData($this->getDummySingleResponse());
        $this->assertInstanceOf(Project::class, $project);
        $this->assertEquals('foo', $project->getAppUrl());
    }

    public function testDateValuesAreDateTimeObjects(): void
    {
        $project = Project::createFromResponseData($this->getDummySingleResponse());
        $this->assertInstanceOf(\DateTime::class, $project->getCreatedAt());
        $this->assertInstanceOf(\DateTime::class, $project->getUpdatedAt());
        $this->assertInstanceOf(\DateTime::class, $project->getStartTime());
    }
}
