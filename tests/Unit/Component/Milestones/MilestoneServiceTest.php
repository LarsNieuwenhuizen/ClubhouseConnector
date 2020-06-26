<?php
declare(strict_types = 1);

namespace LarsNieuwenhuizen\ClubhouseConnector\Tests\Unit\Component\Milestones;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;
use LarsNieuwenhuizen\ClubhouseConnector\Component\ComponentService;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Domain\Model\ComponentCollection;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Exception\ServiceCallException;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Milestones\Domain\Model\Milestone;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Milestones\MilestonesService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

final class MilestoneServiceTest extends TestCase
{

    private MilestonesService $subject;

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
        $this->subject = new MilestonesService($this->clientMock, $this->loggerMock);

        $this->exampleGetResponse = '{
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

        $this->exampleListResponse = '[
          {
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
            'milestones',
            $this->subject->getApiPath()
        );
    }

    public function testListingReturnsAnMilestonesCollection(): void
    {
        $this->streamMock->expects($this->once())
            ->method('getContents')
            ->willReturn($this->exampleListResponse);

        $this->responseMock->expects($this->once())
            ->method('getBody')
            ->willReturn($this->streamMock);

        $this->clientMock->expects($this->once())
            ->method('get')
            ->with('milestones')
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
            ->with('milestones')
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
            ->with('milestones/1')
            ->willReturnReference($this->responseMock);

        $result = $this->subject->get('1');

        $this->assertInstanceOf(Milestone::class, $result);
    }

    public function testGuzzleCallFailureIsLoggedAndThrownBackDuringGet(): void
    {
        $guzzleException = $this->createMock(RequestException::class);
        $this->loggerMock->expects($this->once())
            ->method('error');
        $this->clientMock->expects($this->once())
            ->method('get')
            ->with('milestones/1')
            ->willThrowException($guzzleException);

        $this->expectException(ServiceCallException::class);
        $this->subject->get('1');
    }
}
