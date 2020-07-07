<?php
declare(strict_types=1);

namespace LarsNieuwenhuizen\ClubhouseConnector;

use GuzzleHttp\Client;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Epics\EpicsService;
use LarsNieuwenhuizen\ClubhouseConnector\Component\ComponentService;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Milestones\MilestonesService;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Projects\ProjectsService;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Stories\StoriesService;
use LarsNieuwenhuizen\ClubhouseConnector\Exception\Connector\ConnectorConstructionException;
use LarsNieuwenhuizen\ClubhouseConnector\Exception\Connector\UndefinedMethodException;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Component\Yaml\Yaml;

/**
 * @method EpicsService epics()
 * @method MilestonesService milestones()
 * @method StoriesService stories()
 * @method ProjectsService projects()
 */
final class Connector
{

    const DATE_TIME_FORMAT = 'Y-m-d\TH:i:s\Z';

    private Client $httpClient;
    private array $configuration = [];
    private ComponentService $epicsService;
    private ComponentService $milestonesService;
    private ComponentService $projectsService;
    private ComponentService $storiesService;
    private LoggerInterface $logger;

    public function __construct(string $configurationFilePath, LoggerInterface $logger = null)
    {
        if ($logger === null) {
            $logger = new NullLogger();
        }
        $this->setLogger($logger);
        try {
            $this->setConfiguration((array)Yaml::parseFile($configurationFilePath));
            $httpClient = new Client([
                'base_uri' => $this->getConfiguration()['Clubhouse']['api']['uri'],
                'query' => [
                    'token' => $this->getConfiguration()['Clubhouse']['api']['token']
                ],
                'headers' => [
                    'Content-Type' => 'application/json'
                ]
            ]);
            $this->setHttpClient($httpClient);

            $this->epicsService = new EpicsService($this->getHttpClient(), $this->getLogger());
            $this->milestonesService = new MilestonesService($this->getHttpClient(), $this->getLogger());
            $this->projectsService = new ProjectsService($this->getHttpClient(), $this->getLogger());
            $this->storiesService = new StoriesService($this->getHttpClient(), $this->getLogger());
        } catch (ConnectorConstructionException $connectorConstructionException) {
            $this->getLogger()->error($connectorConstructionException->getMessage());
            throw $connectorConstructionException;
        }
    }

    public function __call($name, $arguments)
    {
        $componentServices = [
            'epics',
            'projects',
            'stories',
            'milestones'
        ];

        if (\in_array($name, $componentServices)) {
            $methodName = 'get' . \ucfirst($name) . 'Service';
            return $this->$methodName();
        }
        throw new UndefinedMethodException();
    }

    public function getHttpClient(): Client
    {
        return $this->httpClient;
    }

    public function setHttpClient(Client $httpClient): Connector
    {
        $this->httpClient = $httpClient;
        return $this;
    }

    public function getConfiguration(): array
    {
        return $this->configuration;
    }

    /**
     * @throws ConnectorConstructionException
     */
    public function setConfiguration(array $configuration): Connector
    {
        $this->configuration = $configuration;
        if (!isset($configuration['Clubhouse']['api']['uri'])) {
            throw new ConnectorConstructionException('The api uri is not set');
        }
        if (!isset($configuration['Clubhouse']['api']['token'])) {
            throw new ConnectorConstructionException('The api token is not set');
        }
        return $this;
    }

    public function getLogger(): LoggerInterface
    {
        return $this->logger;
    }

    public function setLogger(LoggerInterface $logger): Connector
    {
        $this->logger = $logger;
        return $this;
    }

    public function getEpicsService(): ComponentService
    {
        return $this->epicsService;
    }

    public function getMilestonesService(): ComponentService
    {
        return $this->milestonesService;
    }

    public function getProjectsService(): ComponentService
    {
        return $this->projectsService;
    }

    public function getStoriesService(): ComponentService
    {
        return $this->storiesService;
    }
}
