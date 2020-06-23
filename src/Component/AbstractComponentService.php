<?php
declare(strict_types=1);

namespace LarsNieuwenhuizen\ClubhouseConnector\Component;

use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;

abstract class AbstractComponentService implements ComponentService
{

    protected string $apiPath;

    protected Client $client;

    protected LoggerInterface $logger;

    public function __construct(Client $client, LoggerInterface $logger)
    {
        $this->setClient($client);
        $this->setLogger($logger);
    }

    public function getApiPath(): string
    {
        return $this->apiPath;
    }

    public function setApiPath(string $apiPath): ComponentService
    {
        $this->apiPath = $apiPath;
        return $this;
    }

    public function getClient()
    {
        return $this->client;
    }

    public function setClient(Client $client): AbstractComponentService
    {
        $this->client = $client;
        return $this;
    }

    public function getLogger()
    {
        return $this->logger;
    }

    public function setLogger(LoggerInterface $logger): AbstractComponentService
    {
        $this->logger = $logger;
        return $this;
    }
}
