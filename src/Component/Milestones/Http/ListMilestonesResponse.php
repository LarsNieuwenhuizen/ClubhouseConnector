<?php
declare(strict_types = 1);

namespace LarsNieuwenhuizen\ClubhouseConnector\Component\Milestones\Http;

use LarsNieuwenhuizen\ClubhouseConnector\Component\AbstractResponse;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Milestones\Domain\Model\Milestone;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Response\ComponentCollectionResponseTrait;

final class ListMilestonesResponse extends AbstractResponse
{

    use ComponentCollectionResponseTrait;

    public function __construct(string $jsonBody)
    {
        $this->componentClass = Milestone::class;
        parent::__construct($jsonBody);
    }
}
