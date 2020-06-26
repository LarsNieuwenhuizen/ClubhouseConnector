<?php
declare(strict_types = 1);

namespace LarsNieuwenhuizen\ClubhouseConnector\Component\Milestones\Http;

use LarsNieuwenhuizen\ClubhouseConnector\Component\AbstractResponse;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Milestones\Domain\Model\Milestone;

final class GetMilestoneResponse extends AbstractResponse
{

    protected function formatJsonResult(string $json): void
    {
        $data = \json_decode($json, true);
        $milestone = Milestone::createFromResponseData($data);
        $this->body = $milestone;
    }
}
