<?php
declare(strict_types = 1);

namespace LarsNieuwenhuizen\ClubhouseConnector\Component\Stories;

use GuzzleHttp\Exception\GuzzleException;
use LarsNieuwenhuizen\ClubhouseConnector\Component\AbstractComponentService;
use LarsNieuwenhuizen\ClubhouseConnector\Component\ComponentResponseBody;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Domain\Model\StoryCollection;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Exception\MethodDoesNotExistException;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Exception\ServiceCallException;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Stories\Domain\Model\Story;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Stories\Http\GetStoryResponse;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Stories\Http\ListStoriesResponse;

final class StoriesService extends AbstractComponentService
{

    protected string $apiPath = 'stories';

    protected string $componentName = 'story';

    protected string $componentClass = Story::class;

    protected string $getResponseClass = GetStoryResponse::class;

    protected string $listResponseClass = ListStoriesResponse::class;

    public function list(): ComponentResponseBody
    {
        throw new MethodDoesNotExistException('This method is not available for this service');
    }

    public function createBulk(StoryCollection $stories): ComponentResponseBody
    {
        try {
            $call = $this->getClient()->post(
                $this->getApiPath() . '/bulk',
                [
                    'json' => $stories->toArrayForBulkCreation()
                ]
            );
        } catch (GuzzleException $guzzleException) {
            $this->getLogger()->error(
                'Posting bulk of new ' . $this->componentName . ' to Clubhouse failed',
                [
                    'message' => $guzzleException->getMessage()
                ]
            );
            throw new ServiceCallException(
                'Posting bulk of new ' . $this->componentName . ' to Clubhouse failed',
                $guzzleException->getCode(),
                $guzzleException
            );
        }

        return (
            new $this->listResponseClass($call->getBody()->getContents())
        )->getBody();
    }
}
