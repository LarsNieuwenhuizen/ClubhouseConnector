<?php
declare(strict_types=1);

namespace LarsNieuwenhuizen\ClubhouseConnector\Component;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Exception\ComponentCreationException;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Exception\ComponentDeleteException;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Exception\ComponentUpdateException;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Exception\ServiceCallException;
use Psr\Log\LoggerInterface;
use RuntimeException;

abstract class AbstractComponentService implements ComponentService
{

    protected string $apiPath;

    protected Client $client;

    protected LoggerInterface $logger;

    protected string $componentClass;

    protected string $getResponseClass;

    protected string $listResponseClass;

    protected string $componentName = 'component';

    public function __construct(Client $client, LoggerInterface $logger)
    {
        $this->setClient($client);
        $this->setLogger($logger);
    }

    public function get(string $identifier): ComponentResponseBody
    {
        try {
            $path = $this->getApiPath() . '/' . $identifier;
            $call = $this->getClient()->get($path);
        } catch (GuzzleException $exception) {
            $this->logger->error(
                'Fetching single ' . $this->componentName . ' with id: ' . $identifier . ' failed.',
                [
                    'message' => $exception->getMessage()
                ]
            );
            throw new ServiceCallException('Fetching single ' . $this->componentName . ' failed', $exception->getCode(), $exception);
        }
        return (
            new $this->getResponseClass($call->getBody()->getContents())
        )->getBody();
    }

    public function list(): ComponentResponseBody
    {
        try {
            $call = $this->getClient()->get($this->getApiPath());
        } catch (GuzzleException $guzzleException) {
            $this->logger->error(
                'Listing ' . $this->componentName . ' failed',
                [
                    'message' => $guzzleException->getMessage()
                ]
            );
            throw new ServiceCallException(
                'Listing ' . $this->componentName . ' failed',
                $guzzleException->getCode(),
                $guzzleException
            );
        }

        return (
            new $this->listResponseClass($call->getBody()->getContents())
        )->getBody();
    }

    public function create(CreateableComponent $component): ComponentResponseBody
    {
        if (!$component instanceof $this->componentClass) {
            $message = 'The object you are trying to create of type ' . \get_class($component) . ' is not a milestone.';
            $this->getLogger()->error($message);
            throw new ComponentCreationException($message);
        }

        try {
            $call = $this->getClient()->post(
                $this->getApiPath(),
                [
                    'body' => $component->toJsonForCreation()
                ]
            );
        } catch (GuzzleException $guzzleException) {
            $this->getLogger()->error(
                'Posting new ' . $this->componentName . ' to Clubhouse failed',
                [
                    'message' => $guzzleException->getMessage()
                ]
            );
            throw new ServiceCallException(
                'Posting new ' . $this->componentName . ' to Clubhouse failed',
                $guzzleException->getCode(),
                $guzzleException
            );
        }

        return (
            new $this->getResponseClass($call->getBody()->getContents())
        )->getBody();
    }

    public function update(UpdateableComponent $component): ComponentResponseBody
    {
        if (!$component instanceof $this->componentClass) {
            $message = 'The object you are trying to update of type ' .
                \get_class($component) . ' is not a ' . $this->componentName;
            $this->getLogger()->error($message);
            throw new ComponentUpdateException($message);
        }

        try {
            $call = $this->getClient()->put(
                $this->getApiPath() . '/' . $component->getId(),
                [
                    'body' => $component->toJsonForUpdate()
                ]
            );
        } catch (GuzzleException $guzzleException) {
            $this->getLogger()->error(
                'Updating milestone with id: ' . $component->getId() . ' failed',
                [
                    'message' => $guzzleException->getMessage()
                ]
            );
            throw new ComponentUpdateException(
                'Updating milestone with id: ' . $component->getId() . ' failed',
                $guzzleException->getCode(),
                $guzzleException
            );
        }

        return (
            new $this->getResponseClass($call->getBody()->getContents())
        )->getBody();
    }

    public function delete(int $componentId): void
    {
        try {
            $this->client->delete($this->getApiPath() . '/' . $componentId);
        } catch (RuntimeException $guzzleException) {
            $this->getLogger()->error(
                'Deleting ' . $this->componentName . ' with id: ' . $componentId . ' failed',
                [
                    'message' => $guzzleException->getMessage()
                ]
            );
            throw new ComponentDeleteException(
                'Deleting ' . $this->componentName . ' with id: ' . $componentId . ' failed',
                $guzzleException->getCode(),
                $guzzleException
            );
        }

        return;
    }

    public function getApiPath(): string
    {
        return $this->apiPath;
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
