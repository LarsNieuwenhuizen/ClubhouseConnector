<?php
declare(strict_types = 1);

namespace LarsNieuwenhuizen\ClubhouseConnector\Component\Milestones\Http;

use LarsNieuwenhuizen\ClubhouseConnector\Component\AbstractResponse;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Domain\Model\ComponentCollection;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Milestones\Domain\Model\Milestone;

final class ListMilestonesResponse extends AbstractResponse
{

    protected function formatJsonResult(string $jsonResult): void
    {
        $data = \json_decode($jsonResult, true);
        $collection = new ComponentCollection();
        foreach ($data as $milestone) {
            $milestone = Milestone::createFromResponseData($milestone);
            $collection->addComponent($milestone);
        }
        $this->body = $collection;
    }
}
