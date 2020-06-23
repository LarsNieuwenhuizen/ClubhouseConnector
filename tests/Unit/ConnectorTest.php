<?php
declare(strict_types=1);

namespace LarsNieuwenhuizen\ClubhouseConnector\Tests\Unit;

use LarsNieuwenhuizen\ClubhouseConnector\Connector;
use LarsNieuwenhuizen\ClubhouseConnector\Exception\Connector\ConnectorConstructionException;
use PHPUnit\Framework\TestCase;

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
}
