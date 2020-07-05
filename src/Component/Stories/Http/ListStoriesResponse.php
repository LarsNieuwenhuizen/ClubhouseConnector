<?php
declare(strict_types = 1);

namespace LarsNieuwenhuizen\ClubhouseConnector\Component\Stories\Http;

use LarsNieuwenhuizen\ClubhouseConnector\Component\AbstractResponse;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Response\ComponentCollectionResponseTrait;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Stories\Domain\Model\Story;

final class ListStoriesResponse extends AbstractResponse
{

    use ComponentCollectionResponseTrait;

    public function __construct(string $jsonBody)
    {
        $this->componentClass = Story::class;
        parent::__construct($jsonBody);
    }
}
