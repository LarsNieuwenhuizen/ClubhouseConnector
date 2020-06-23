<?php
declare(strict_types=1);

namespace LarsNieuwenhuizen\ClubhouseConnector\Component\Epics;

use GuzzleHttp\Exception\ClientException;
use LarsNieuwenhuizen\ClubhouseConnector\Component\AbstractComponentService;
use LarsNieuwenhuizen\ClubhouseConnector\Component\ComponentResponseBody;
use LarsNieuwenhuizen\ClubhouseConnector\Component\CreateableComponent;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Epics\Domain\Model\Epic;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Epics\Http\GetEpicResponse;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Epics\Http\ListEpicsResponse;

final class EpicsService extends AbstractComponentService
{

    protected string $apiPath = 'epics';

    public function get(string $identifier): ComponentResponseBody
    {
        $path = $this->getApiPath() . '/' . $identifier;
        $call = $this->getClient()->get($path);
        return (
            new GetEpicResponse($call->getBody()->getContents())
        )->getBody();
    }

    public function list(): ComponentResponseBody
    {
        $call = $this->getClient()->get($this->getApiPath());
        return (
            new ListEpicsResponse($call->getBody()->getContents())
        )->getBody();
    }

    public function create(CreateableComponent $epic): ComponentResponseBody
    {
        if (!$epic instanceof Epic) {
            throw new \Exception('You trying to create the wrong object here');
        }

        try {
            $call = $this->getClient()->post(
                $this->getApiPath(),
                [
//                'body' => $epic->toJsonForCreation()
                ]
            );

            return (
                new GetEpicResponse($call->getBody()->getContents())
            )->getBody();
        } catch (ClientException $clientException) {
            $this->getLogger()->error($clientException->getMessage());
        }
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
