<?php
declare(strict_types=1);

namespace LarsNieuwenhuizen\ClubhouseConnector\Component\Milestones;

use GuzzleHttp\Exception\GuzzleException;
use LarsNieuwenhuizen\ClubhouseConnector\Component\AbstractComponentService;
use LarsNieuwenhuizen\ClubhouseConnector\Component\ComponentResponseBody;
use LarsNieuwenhuizen\ClubhouseConnector\Component\ComponentService;
use LarsNieuwenhuizen\ClubhouseConnector\Component\CreateableComponent;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Exception\ComponentCreationException;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Milestones\Domain\Model\Milestone;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Milestones\Http\GetMilestoneResponse;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Exception\ServiceCallException;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Milestones\Http\ListMilestonesResponse;
use LarsNieuwenhuizen\ClubhouseConnector\Component\UpdateableComponent;

final class MilestonesService extends AbstractComponentService implements ComponentService
{

    protected string $apiPath = 'milestones';

    public function get(string $identifier): ComponentResponseBody
    {
        try {
            $path = $this->getApiPath() . '/' . $identifier;
            $call = $this->getClient()->get($path);
        } catch (GuzzleException $exception) {
            $this->logger->error(
                'Fetching single milestone with id: ' . $identifier . ' failed.',
                [
                    'message' => $exception->getMessage()
                ]
            );
            throw new ServiceCallException('Fetching single milestone failed', $exception->getCode(), $exception);
        }
        return (
        new GetMilestoneResponse($call->getBody()->getContents())
        )->getBody();
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

    public function create(CreateableComponent $milestone): ComponentResponseBody
    {
        if (!$milestone instanceof Milestone) {
            $message = 'The object you are trying to create of type ' . \get_class($milestone) . ' is not a milestone.';
            $this->getLogger()->error($message);
            throw new ComponentCreationException($message);
        }

        try {
            $call = $this->getClient()->post(
                $this->getApiPath(),
                [
                    'body' => $milestone->toJsonForCreation()
                ]
            );
        } catch (GuzzleException $guzzleException) {
            $this->getLogger()->error(
                'Posting new Milestone to Clubhouse failed',
                [
                    'message' => $guzzleException->getMessage()
                ]
            );
            throw new ServiceCallException(
                'Posting new Milestone to Clubhouse failed',
                $guzzleException->getCode(),
                $guzzleException
            );
        }

        return (
            new GetMilestoneResponse($call->getBody()->getContents())
        )->getBody();
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
