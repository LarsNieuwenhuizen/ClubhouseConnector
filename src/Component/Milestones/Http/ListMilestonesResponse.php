<?php
declare(strict_types = 1);

namespace LarsNieuwenhuizen\ClubhouseConnector\Component\Milestones\Http;

use LarsNieuwenhuizen\ClubhouseConnector\Component\AbstractResponse;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Milestones\Domain\Model\Milestone;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Milestones\Domain\Model\MilestoneCollection;

final class ListMilestonesResponse extends AbstractResponse
{

    protected function formatJsonResult(string $jsonResult): void
    {
        $data = \json_decode($jsonResult, true);
        $collection = new MilestoneCollection();
        foreach ($data as $milestone) {
            $milestone = Milestone::createFromResponseData($milestone);
            $collection->addMilestone($milestone);
        }
        $this->body = $collection;
    }
}
