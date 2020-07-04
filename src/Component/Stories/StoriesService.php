<?php
declare(strict_types = 1);

namespace LarsNieuwenhuizen\ClubhouseConnector\Component\Stories;

use LarsNieuwenhuizen\ClubhouseConnector\Component\AbstractComponentService;
use LarsNieuwenhuizen\ClubhouseConnector\Component\ComponentResponseBody;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Exception\MethodDoesNotExistException;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Stories\Domain\Model\Story;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Stories\Http\GetStoryResponse;

final class StoriesService extends AbstractComponentService
{

    protected string $apiPath = 'stories';

    protected string $componentName = 'story';

    protected string $componentClass = Story::class;

    protected string $getResponseClass = GetStoryResponse::class;

    public function list(): ComponentResponseBody
    {
        throw new MethodDoesNotExistException('This method is not available for this service');
    }
}
