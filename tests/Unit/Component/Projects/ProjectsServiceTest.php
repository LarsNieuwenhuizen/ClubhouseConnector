<?php
declare(strict_types = 1);

namespace LarsNieuwenhuizen\ClubhouseConnector\Tests\Unit\Component\Projects;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;
use LarsNieuwenhuizen\ClubhouseConnector\Component\ComponentService;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Domain\Model\ComponentCollection;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Epics\Domain\Model\Epic;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Projects\Domain\Model\Project;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Exception\ComponentCreationException;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Exception\ComponentDeleteException;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Exception\ComponentUpdateException;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Exception\ServiceCallException;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Projects\ProjectsService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use RuntimeException;

final class ProjectsServiceTest extends TestCase
{

    private ProjectsService $subject;

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
        $this->subject = new ProjectsService($this->clientMock, $this->loggerMock);

        $this->exampleGetResponse = '{
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

        $this->exampleListResponse = '[
          {
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
          }
        ]';
        parent::setUp();
    }

    public function testServiceIsComponentService(): void
    {
        $this->assertInstanceOf(ComponentService::class, $this->subject);
    }

    public function testApiPathIsSet(): void
    {
        $this->assertEquals(
            'projects',
            $this->subject->getApiPath()
        );
    }

    public function testListingReturnsAnProjectsCollection(): void
    {
        $this->streamMock->expects($this->once())
            ->method('getContents')
            ->willReturn($this->exampleListResponse);

        $this->responseMock->expects($this->once())
            ->method('getBody')
            ->willReturn($this->streamMock);

        $this->clientMock->expects($this->once())
            ->method('get')
            ->with('projects')
            ->willReturnReference($this->responseMock);

        $result = $this->subject->list();

        $this->assertInstanceOf(ComponentCollection::class, $result);
    }

    public function testGuzzleCallFailureIsLoggedAndThrownBackDuringListing(): void
    {
        $guzzleException = $this->createMock(RequestException::class);
        $this->loggerMock->expects($this->once())
            ->method('error');
        $this->clientMock->expects($this->once())
            ->method('get')
            ->with('projects')
            ->willThrowException($guzzleException);

        $this->expectException(ServiceCallException::class);
        $this->subject->list();
    }

    public function testGettingReturnsAnMilestone(): void
    {
        $this->streamMock->expects($this->once())
            ->method('getContents')
            ->willReturn($this->exampleGetResponse);

        $this->responseMock->expects($this->once())
            ->method('getBody')
            ->willReturn($this->streamMock);

        $this->clientMock->expects($this->once())
            ->method('get')
            ->with('projects/1')
            ->willReturnReference($this->responseMock);

        $result = $this->subject->get('1');

        $this->assertInstanceOf(Project::class, $result);
    }

    public function testGuzzleCallFailureIsLoggedAndThrownBackDuringGet(): void
    {
        $guzzleException = $this->createMock(RequestException::class);
        $this->loggerMock->expects($this->once())
            ->method('error');
        $this->clientMock->expects($this->once())
            ->method('get')
            ->with('projects/1')
            ->willThrowException($guzzleException);

        $this->expectException(ServiceCallException::class);
        $this->subject->get('1');
    }

    public function testOnlyProjectsCanBeMadeInCreate(): void
    {
        $this->expectException(ComponentCreationException::class);
        $differentCreatableComponentObject = new Epic();
        $this->loggerMock->expects($this->once())
            ->method('error');

        $this->subject->create($differentCreatableComponentObject);
    }

    public function testProjectIsReturnedAfterSuccessfulCreation(): void
    {
        $project = new Project();
        $project->setName('dummy')
            ->setTeamId(1);

        $this->streamMock->expects($this->once())
            ->method('getContents')
            ->willReturn($this->exampleGetResponse);

        $this->responseMock->expects($this->once())
            ->method('getBody')
            ->willReturn($this->streamMock);

        $this->clientMock->expects($this->once())
            ->method('post')
            ->with('projects', ['body' => $project->toJsonForCreation()])
            ->willReturn($this->responseMock);

        $result = $this->subject->create($project);
        $this->assertInstanceOf(Project::class, $result);
    }

    public function testGuzzleCallFailureIsLoggedAndThrownBackDuringCreate(): void
    {
        $milestone = (new Project())->setName('dummy')
            ->setUpdatedAt(new \DateTime('now'));
        $guzzleException = $this->createMock(RequestException::class);

        $this->loggerMock->expects($this->once())
            ->method('error');

        $this->clientMock->expects($this->once())
            ->method('post')
            ->with('projects', ['body' => $milestone->toJsonForCreation()])
            ->willThrowException($guzzleException);

        $this->expectException(ServiceCallException::class);
        $this->subject->create($milestone);
    }

    public function testProjectIsReturnedAfterSuccessfulUpdate(): void
    {
        $project = Project::createFromResponseData(\json_decode($this->exampleGetResponse, true));
        $this->streamMock->expects($this->once())
            ->method('getContents')
            ->willReturn($this->exampleGetResponse);

        $this->responseMock->expects($this->once())
            ->method('getBody')
            ->willReturn($this->streamMock);

        $this->clientMock->expects($this->once())
            ->method('put')
            ->with('projects/123', ['body' => $project->toJsonForUpdate()])
            ->willReturn($this->responseMock);

        $result = $this->subject->update($project);
        $this->assertInstanceOf(Project::class, $result);
    }

    public function testGuzzleCallFailureIsLoggedAndThrownBackDuringUpdate(): void
    {
        $project = Project::createFromResponseData(\json_decode($this->exampleGetResponse, true));
        $guzzleException = $this->createMock(RequestException::class);

        $this->loggerMock->expects($this->once())
            ->method('error');

        $this->clientMock->expects($this->once())
            ->method('put')
            ->with('projects/123', ['body' => $project->toJsonForUpdate()])
            ->willThrowException($guzzleException);

        $this->expectException(ComponentUpdateException::class);
        $this->subject->update($project);
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
            ->with('projects/1')
            ->willThrowException($guzzleException);

        $this->expectException(ComponentDeleteException::class);
        $this->subject->delete(1);
    }
}
