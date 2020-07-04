<?php
declare(strict_types = 1);

namespace LarsNieuwenhuizen\ClubhouseConnector\Tests\Unit\Component\Stories;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;
use LarsNieuwenhuizen\ClubhouseConnector\Component\ComponentService;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Domain\Model\ComponentCollection;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Epics\Domain\Model\Epic;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Exception\MethodDoesNotExistException;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Stories\Domain\Model\Story;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Exception\ComponentCreationException;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Exception\ComponentDeleteException;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Exception\ComponentUpdateException;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Exception\ServiceCallException;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Stories\StoriesService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use RuntimeException;

final class StoriesServiceTest extends TestCase
{

    private StoriesService $subject;

    private string $exampleGetResponse;
    private MockObject $clientMock;
    private MockObject $loggerMock;
    private MockObject $responseMock;
    private MockObject $streamMock;

    protected function setUp(): void
    {
        $this->loggerMock = $this->createMock(NullLogger::class);
        $this->clientMock = $this->getMockBuilder(Client::class)
            ->addMethods(['get', 'post', 'put', 'delete'])
            ->onlyMethods(['request'])
            ->getMock();
        $this->responseMock = $this->createMock(Response::class);
        $this->streamMock = $this->createMock(Stream::class);
        $this->subject = new StoriesService($this->clientMock, $this->loggerMock);

        $this->exampleGetResponse = '{
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
        parent::setUp();
    }

    public function testServiceIsComponentService(): void
    {
        $this->assertInstanceOf(ComponentService::class, $this->subject);
    }

    public function testApiPathIsSet(): void
    {
        $this->assertEquals(
            'stories',
            $this->subject->getApiPath()
        );
    }

    public function testListingIsNotAvailableForStories(): void
    {
        $this->expectException(MethodDoesNotExistException::class);
        $this->subject->list();
    }

    public function testGettingReturnsAStory(): void
    {
        $this->streamMock->expects($this->once())
            ->method('getContents')
            ->willReturn($this->exampleGetResponse);

        $this->responseMock->expects($this->once())
            ->method('getBody')
            ->willReturn($this->streamMock);

        $this->clientMock->expects($this->once())
            ->method('get')
            ->with('stories/1')
            ->willReturnReference($this->responseMock);

        $result = $this->subject->get('1');

        $this->assertInstanceOf(Story::class, $result);
    }

    public function testGuzzleCallFailureIsLoggedAndThrownBackDuringGet(): void
    {
        $guzzleException = $this->createMock(RequestException::class);
        $this->loggerMock->expects($this->once())
            ->method('error');
        $this->clientMock->expects($this->once())
            ->method('get')
            ->with('stories/1')
            ->willThrowException($guzzleException);

        $this->expectException(ServiceCallException::class);
        $this->subject->get('1');
    }

    public function testOnlyStoriesCanBeMadeInCreate(): void
    {
        $this->expectException(ComponentCreationException::class);
        $differentCreatableComponentObject = new Epic();
        $this->loggerMock->expects($this->once())
            ->method('error');

        $this->subject->create($differentCreatableComponentObject);
    }

    public function testStoryIsReturnedAfterSuccessfulCreation(): void
    {
        $story = new Story();
        $story->setName('dummy')
            ->setCreatedAt(new \DateTime('now'))
            ->setUpdatedAt(new \DateTime('now'))
            ->setStartedAt(new \DateTime('now'))
            ->setStartedAtOverride(new \DateTime('now'))
            ->setDeadline(new \DateTime('now'))
            ->setCompletedAtOverride(new \DateTime('now'))
            ->setCompletedAt(new \DateTime('now'))
            ->setArchived(false)
            ->setBlocked(false)
            ->setCompleted(false)
            ->setTasks([])
            ->setFileIds([])
            ->setComments([])
            ->setRequestedById('1')
            ->setDescription('Description')
            ->setAppUrl('app')
            ->setBranches([])
            ->setCommits([])
            ->setStoryType('chore')
            ->setStats([])
            ->setProjectId(1);

        $this->streamMock->expects($this->once())
            ->method('getContents')
            ->willReturn($this->exampleGetResponse);

        $this->responseMock->expects($this->once())
            ->method('getBody')
            ->willReturn($this->streamMock);

        $this->clientMock->expects($this->once())
            ->method('post')
            ->with('stories', ['body' => $story->toJsonForCreation()])
            ->willReturn($this->responseMock);

        $result = $this->subject->create($story);
        $this->assertInstanceOf(Story::class, $result);
    }

    public function testGuzzleCallFailureIsLoggedAndThrownBackDuringCreate(): void
    {
        $story = (new Story())->setName('dummy')
            ->setProjectId(1);
        $guzzleException = $this->createMock(RequestException::class);

        $this->loggerMock->expects($this->once())
            ->method('error');

        $this->clientMock->expects($this->once())
            ->method('post')
            ->with('stories', ['body' => $story->toJsonForCreation()])
            ->willThrowException($guzzleException);

        $this->expectException(ServiceCallException::class);
        $this->subject->create($story);
    }

    public function testStoryIsReturnedAfterSuccessfulUpdate(): void
    {
        $story = Story::createFromResponseData(\json_decode($this->exampleGetResponse, true));
        $story->setAfterStory(2)
            ->setBeforeStory(4)
            ->setArchived(true)
            ->setBlocked(true);
        $this->streamMock->expects($this->once())
            ->method('getContents')
            ->willReturn($this->exampleGetResponse);

        $this->responseMock->expects($this->once())
            ->method('getBody')
            ->willReturn($this->streamMock);

        $this->clientMock->expects($this->once())
            ->method('put')
            ->with('stories/123', ['body' => $story->toJsonForUpdate()])
            ->willReturn($this->responseMock);

        $result = $this->subject->update($story);
        $this->assertInstanceOf(Story::class, $result);
    }

    public function testGuzzleCallFailureIsLoggedAndThrownBackDuringUpdate(): void
    {
        $story = Story::createFromResponseData(\json_decode($this->exampleGetResponse, true));
        $guzzleException = $this->createMock(RequestException::class);

        $this->loggerMock->expects($this->once())
            ->method('error');

        $this->clientMock->expects($this->once())
            ->method('put')
            ->with('stories/123', ['body' => $story->toJsonForUpdate()])
            ->willThrowException($guzzleException);

        $this->expectException(ComponentUpdateException::class);
        $this->subject->update($story);
    }

    public function testVoidReturnedAfterSuccessfulDelete(): void
    {
        $result = $this->subject->delete(1);
        $this->assertNull($result);
    }

    public function testGuzzleCallFailureIsLoggedAndThrownBackDuringDelete(): void
    {
        $guzzleException = $this->createMock(RuntimeException::class);

        $this->loggerMock->expects($this->once())
            ->method('error');

        $this->clientMock->expects($this->once())
            ->method('delete')
            ->with('stories/1')
            ->willThrowException($guzzleException);

        $this->expectException(ComponentDeleteException::class);
        $this->subject->delete(1);
    }
}
