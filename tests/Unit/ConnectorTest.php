<?php
declare(strict_types=1);

namespace LarsNieuwenhuizen\ClubhouseConnector\Tests\Unit;

use LarsNieuwenhuizen\ClubhouseConnector\Component\ComponentService;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Epics\EpicsService;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Milestones\MilestonesService;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Projects\ProjectsService;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Stories\StoriesService;
use LarsNieuwenhuizen\ClubhouseConnector\Connector;
use LarsNieuwenhuizen\ClubhouseConnector\Exception\Connector\ConnectorConstructionException;
use LarsNieuwenhuizen\ClubhouseConnector\Exception\Connector\UndefinedMethodException;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class ConnectorTest extends TestCase
{

    protected Connector $subject;

    protected function setUp(): void
    {
        $this->subject = new Connector(__DIR__ . '/DummyConfigFiles/CorrectDummyConfig.yaml');
        parent::setUp();
    }

    public function testExceptionIsThrownWhenConfigurationIsEmpty(): void
    {
        $this->expectException(ConnectorConstructionException::class);
        new Connector(__DIR__ . '/DummyConfigFiles/EmptyConfig.yaml');
    }

    public function testExceptionIsThrownWhenApiHostIsMissingInConfiguration(): void
    {
        $this->expectException(ConnectorConstructionException::class);
        $this->expectExceptionMessage('The api uri is not set');
        new Connector(__DIR__ . '/DummyConfigFiles/MissingHostConfig.yaml');
    }

    public function testExceptionIsThrownWhenApiTokenIsMissingInConfiguration(): void
    {
        $this->expectException(ConnectorConstructionException::class);
        $this->expectExceptionMessage('The api token is not set');
        new Connector(__DIR__ . '/DummyConfigFiles/MissingTokenConfig.yaml');
    }

    public function testThatLoggerIsAlwaysAvailable(): void
    {
        $this->assertInstanceOf(LoggerInterface::class, $this->subject->getLogger());
    }

    public function testEpicsServiceIsAvailable(): void
    {
        $this->assertInstanceOf(ComponentService::class, $this->subject->getEpicsService());
    }

    public function testMilestoneServiceIsAvailable(): void
    {
        $this->assertInstanceOf(ComponentService::class, $this->subject->getMilestonesService());
    }

    public function testCorrectMagicMethodReturns(): void
    {
        $this->assertInstanceOf(EpicsService::class, $this->subject->epics());
        $this->assertInstanceOf(MilestonesService::class, $this->subject->milestones());
        $this->assertInstanceOf(ProjectsService::class, $this->subject->projects());
        $this->assertInstanceOf(StoriesService::class, $this->subject->stories());
    }

    public function testIncorrectMagicMethodThrowsCorrectException(): void
    {
        $this->expectException(UndefinedMethodException::class);
        $this->subject->stones();
    }
}
