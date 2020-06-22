<?php
declare(strict_types=1);

namespace LarsNieuwenhuizen\ClubhouseConnector;

use GuzzleHttp\Client;
use LarsNieuwenhuizen\ClubhouseConnector\Exception\Connector\ConnectorConstructionException;
use Symfony\Component\Yaml\Yaml;

final class Connector
{

    private Client $httpClient;
    private array $configuration = [];

    public function __construct(string $configurationFilePath)
    {
        $this->setConfiguration((array)Yaml::parseFile($configurationFilePath));
        $httpClient = new Client([
           'base_uri' => $this->getConfiguration()['Clubhouse']['api']['uri'],
            'query' => [
                'token' => $this->getConfiguration()['Clubhouse']['api']['token']
            ]
        ]);
        $this->setHttpClient($httpClient);
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
}
