<?php
declare(strict_types=1);

namespace LarsNieuwenhuizen\ClubhouseConnector\Tests\Unit\Component\Epics;

use Guzzle\Common\Exception\RuntimeException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;
use LarsNieuwenhuizen\ClubhouseConnector\Component\ComponentService;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Epics\Domain\Model\Epic;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Epics\Domain\Model\EpicCollection;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Epics\EpicsService;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Exception\ComponentCreationException;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Exception\ComponentDeleteException;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Exception\ComponentUpdateException;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Exception\ServiceCallException;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Milestones\Domain\Model\Milestone;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

final class EpicServiceTest extends TestCase
{

    private EpicsService $subject;

    private string $exampleListResponse;
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
        $this->subject = new EpicsService($this->clientMock, $this->loggerMock);

        $this->exampleGetResponse = '{
          "app_url": "foo",
          "archived": true,
          "comments": [{
            "app_url": "foo",
            "author_id": "12345678-9012-3456-7890-123456789012",
            "comments": [],
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
        $this->exampleListResponse = '[
          {
            "app_url": "foo",
            "archived": true,
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
          }
        ]';
        parent::setUp();
    }

    public function testEpicServiceIsComponentService(): void
    {
        $this->assertInstanceOf(ComponentService::class, $this->subject);
    }

    public function testApiPathIsSet(): void
    {
        $this->assertEquals(
            'epics',
            $this->subject->getApiPath()
        );
    }

    public function testListingReturnsAnEpicCollection(): void
    {
        $this->streamMock->expects($this->once())
            ->method('getContents')
            ->willReturn($this->exampleListResponse);

        $this->responseMock->expects($this->once())
            ->method('getBody')
            ->willReturn($this->streamMock);

        $this->clientMock->expects($this->once())
            ->method('get')
            ->with('epics')
            ->willReturnReference($this->responseMock);

        $result = $this->subject->list();

        $this->assertInstanceOf(EpicCollection::class, $result);
    }

    public function testGuzzleCallFailureIsLoggedAndThrownBackDuringListing(): void
    {
        $guzzleException = $this->createMock(RequestException::class);
        $this->loggerMock->expects($this->once())
            ->method('error');
        $this->clientMock->expects($this->once())
            ->method('get')
            ->with('epics')
            ->willThrowException($guzzleException);

        $this->expectException(ServiceCallException::class);
        $this->subject->list();
    }

    public function testGettingReturnsAnEpic(): void
    {
        $this->streamMock->expects($this->once())
            ->method('getContents')
            ->willReturn($this->exampleGetResponse);

        $this->responseMock->expects($this->once())
            ->method('getBody')
            ->willReturn($this->streamMock);

        $this->clientMock->expects($this->once())
            ->method('get')
            ->with('epics/1')
            ->willReturnReference($this->responseMock);

        $result = $this->subject->get('1');

        $this->assertInstanceOf(Epic::class, $result);
    }

    public function testGuzzleCallFailureIsLoggedAndThrownBackDuringGet(): void
    {
        $guzzleException = $this->createMock(RequestException::class);
        $this->loggerMock->expects($this->once())
            ->method('error');
        $this->clientMock->expects($this->once())
            ->method('get')
            ->with('epics/1')
            ->willThrowException($guzzleException);

        $this->expectException(ServiceCallException::class);
        $this->subject->get('1');
    }

    public function testOnlyEpicsCanBeMadeInCreate(): void
    {
        $this->expectException(ComponentCreationException::class);
        $differentCreatableComponentObject = new Milestone();
        $this->loggerMock->expects($this->once())
            ->method('error');

        $this->subject->create($differentCreatableComponentObject);
    }

    public function testOnlyEpicsCanBeUpdatedInUpdate(): void
    {
        $this->expectException(ComponentUpdateException::class);
        $differentCreatableComponentObject = new Milestone();
        $this->loggerMock->expects($this->once())
            ->method('error');

        $this->subject->update($differentCreatableComponentObject);
    }

    public function testEpicIsReturnedAfterSuccessfulCreation(): void
    {
        $epic = new Epic();
        $epic->setName('dummy');

        $this->streamMock->expects($this->once())
            ->method('getContents')
            ->willReturn($this->exampleGetResponse);

        $this->responseMock->expects($this->once())
            ->method('getBody')
            ->willReturn($this->streamMock);

        $this->clientMock->expects($this->once())
            ->method('post')
            ->with('epics', ['body' => $epic->toJsonForCreation()])
            ->willReturn($this->responseMock);

        $result = $this->subject->create($epic);
        $this->assertInstanceOf(Epic::class, $result);
    }

    public function testGuzzleCallFailureIsLoggedAndThrownBackDuringCreate(): void
    {
        $epic = (new Epic())->setName('dummy')
            ->setDeadline(new \DateTime('now'))
            ->setCompletedAtOverride(new \DateTime('now'))
            ->setPlannedStartDate(new \DateTime('now'))
            ->setStartedAtOverride(new \DateTime('now'))
            ->setUpdatedAt(new \DateTime('now'));
        $guzzleException = $this->createMock(RequestException::class);

        $this->loggerMock->expects($this->once())
            ->method('error');

        $this->clientMock->expects($this->once())
            ->method('post')
            ->with('epics', ['body' => $epic->toJsonForCreation()])
            ->willThrowException($guzzleException);

        $this->expectException(ServiceCallException::class);
        $this->subject->create($epic);
    }

    public function testEpicIsReturnedAfterSuccessfulUpdate(): void
    {
        $epic = Epic::createFromResponseData(\json_decode($this->exampleGetResponse, true))
            ->setDeadline(new \DateTime('now'))
            ->setStartedAtOverride(new \DateTime('now'))
            ->setCompletedAtOverride(new \DateTime('now'))
            ->setPlannedStartDate(new \DateTime('now'))
            ->setBeforeEpic(1)
            ->setAfterEpic(2);

        $this->streamMock->expects($this->once())
            ->method('getContents')
            ->willReturn($this->exampleGetResponse);

        $this->responseMock->expects($this->once())
            ->method('getBody')
            ->willReturn($this->streamMock);

        $this->clientMock->expects($this->once())
            ->method('put')
            ->with('epics/123', ['body' => $epic->toJsonForUpdate()])
            ->willReturn($this->responseMock);

        $result = $this->subject->update($epic);
        $this->assertInstanceOf(Epic::class, $result);
    }

    public function testGuzzleCallFailureIsLoggedAndThrownBackDuringUpdate(): void
    {
        $epic = Epic::createFromResponseData(\json_decode($this->exampleGetResponse, true));
        $guzzleException = $this->createMock(RequestException::class);

        $this->loggerMock->expects($this->once())
            ->method('error');

        $this->clientMock->expects($this->once())
            ->method('put')
            ->with('epics/123', ['body' => $epic->toJsonForUpdate()])
            ->willThrowException($guzzleException);

        $this->expectException(ComponentUpdateException::class);
        $this->subject->update($epic);
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
            ->with('epics/1')
            ->willThrowException($guzzleException);

        $this->expectException(ComponentDeleteException::class);
        $this->subject->delete(1);
    }
}
