<?php
declare(strict_types=1);

namespace LarsNieuwenhuizen\ClubhouseConnector\Component\Milestones;

use GuzzleHttp\Exception\GuzzleException;
use LarsNieuwenhuizen\ClubhouseConnector\Component\AbstractComponentService;
use LarsNieuwenhuizen\ClubhouseConnector\Component\ComponentResponseBody;
use LarsNieuwenhuizen\ClubhouseConnector\Component\ComponentService;
use LarsNieuwenhuizen\ClubhouseConnector\Component\CreateableComponent;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Exception\ServiceCallException;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Milestones\Http\ListMilestonesResponse;
use LarsNieuwenhuizen\ClubhouseConnector\Component\UpdateableComponent;

final class MilestonesService extends AbstractComponentService implements ComponentService
{

    protected string $apiPath = 'milestones';

    public function get(string $identifier): ComponentResponseBody
    {
        // TODO: Implement get() method.
    }

    public function list(): ComponentResponseBody
    {
        try {
            $call = $this->getClient()->get($this->getApiPath());
        } catch (GuzzleException $guzzleException) {
            $this->logger->error(
                'Listing Milstones failed',
                [
                    'message' => $guzzleException->getMessage()
                ]
            );
            throw new ServiceCallException('Listing Epics failed', $guzzleException->getCode(), $guzzleException);
        }

        return (
            new ListMilestonesResponse($call->getBody()->getContents())
        )->getBody();
    }

    public function create(CreateableComponent $component): ComponentResponseBody
    {
        // TODO: Implement create() method.
    }

    public function delete(int $componentId): void
    {
        // TODO: Implement delete() method.
    }

    public function update(UpdateableComponent $component): ComponentResponseBody
    {
        // TODO: Implement update() method.
    }
}
