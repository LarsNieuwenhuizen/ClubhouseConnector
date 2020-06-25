<?php
declare(strict_types=1);

namespace LarsNieuwenhuizen\ClubhouseConnector\Component\Epics;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use LarsNieuwenhuizen\ClubhouseConnector\Component\AbstractComponentService;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Exception\ComponentCreationException;
use LarsNieuwenhuizen\ClubhouseConnector\Component\ComponentResponseBody;
use LarsNieuwenhuizen\ClubhouseConnector\Component\CreateableComponent;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Epics\Domain\Model\Epic;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Epics\Http\GetEpicResponse;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Epics\Http\ListEpicsResponse;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Exception\ServiceCallException;

final class EpicsService extends AbstractComponentService
{

    protected string $apiPath = 'epics';

    /**
     * @param string $identifier
     * @return ComponentResponseBody
     * @throws ServiceCallException
     */
    public function get(string $identifier): ComponentResponseBody
    {
        try {
            $path = $this->getApiPath() . '/' . $identifier;
            $call = $this->getClient()->request('get', $path);
        } catch (GuzzleException $exception) {
            $this->logger->error(
                'Fetching single epic with id: ' . $identifier . ' failed.',
                [
                    'message' => $exception->getMessage()
                ]
            );
            throw new ServiceCallException('Fetching single epic failed', $exception->getCode(), $exception);
        }
        return (
            new GetEpicResponse($call->getBody()->getContents())
        )->getBody();
    }

    /**
     * @return ComponentResponseBody
     * @throws ServiceCallException
     */
    public function list(): ComponentResponseBody
    {
        try {
            $call = $this->getClient()->request('get', $this->getApiPath());
        } catch (GuzzleException $exception) {
            $this->logger->error(
                'Listing Epics failed',
                [
                    'message' => $exception->getMessage()
                ]
            );
            throw new ServiceCallException('Listing Epics failed', $exception->getCode(), $exception);
        }
        return (
            new ListEpicsResponse($call->getBody()->getContents())
        )->getBody();
    }

    /**
     * @param CreateableComponent $epic
     * @return ComponentResponseBody
     * @throws ComponentCreationException
     * @throws ServiceCallException
     */
    public function create(CreateableComponent $epic): ComponentResponseBody
    {
        if (!$epic instanceof Epic) {
            $message = 'The object you are trying to create of type ' . \get_class($epic) . ' is not an epic.';
            $this->getLogger()->error($message);
            throw new ComponentCreationException($message);
        }

        try {
            $call = $this->getClient()->request(
                'post',
                $this->getApiPath(),
                [
                    'body' => $epic->toJsonForCreation()
                ]
            );
        } catch (GuzzleException $guzzleException) {
            $this->getLogger()->error(
                'Posting new Epic to Clubhouse failed',
                [
                    'message' => $guzzleException->getMessage()
                ]
            );
            throw new ServiceCallException(
                'Posting new Epic to Clubhouse failed',
                $guzzleException->getCode(),
                $guzzleException
            );
        }

        return (
            new GetEpicResponse($call->getBody()->getContents())
        )->getBody();
    }

    public function delete(): ComponentResponseBody
    {
        // TODO: Implement delete() method.
    }

    public function update(): ComponentResponseBody
    {
        // TODO: Implement update() method.
    }
}
