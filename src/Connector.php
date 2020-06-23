<?php
declare(strict_types=1);

namespace LarsNieuwenhuizen\ClubhouseConnector;

use GuzzleHttp\Client;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Epics\EpicsService;
use LarsNieuwenhuizen\ClubhouseConnector\Component\ComponentService;
use LarsNieuwenhuizen\ClubhouseConnector\Exception\Connector\ConnectorConstructionException;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Component\Yaml\Yaml;

final class Connector
{

    private Client $httpClient;
    private array $configuration = [];
    private ComponentService $epicsService;
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
        } catch (ConnectorConstructionException $connectorConstructionException) {
            $this->getLogger()->error($connectorConstructionException->getMessage());
            throw $connectorConstructionException;
        }
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

    public function getLogger()
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
}
