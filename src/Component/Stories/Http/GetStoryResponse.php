<?php
declare(strict_types = 1);

namespace LarsNieuwenhuizen\ClubhouseConnector\Component\Stories\Http;

use LarsNieuwenhuizen\ClubhouseConnector\Component\AbstractResponse;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Response\SingleComponentResponseTrait;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Stories\Domain\Model\Story;

final class GetStoryResponse extends AbstractResponse
{

    use SingleComponentResponseTrait;

    public function __construct(string $jsonBody)
    {
        $this->componentClass = Story::class;
        parent::__construct($jsonBody);
    }
}
