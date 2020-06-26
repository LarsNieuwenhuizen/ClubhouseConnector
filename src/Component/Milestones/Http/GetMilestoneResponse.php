<?php
declare(strict_types = 1);

namespace LarsNieuwenhuizen\ClubhouseConnector\Component\Milestones\Http;

use LarsNieuwenhuizen\ClubhouseConnector\Component\AbstractResponse;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Milestones\Domain\Model\Milestone;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Response\SingleComponentResponseTrait;

final class GetMilestoneResponse extends AbstractResponse
{

    use SingleComponentResponseTrait;

    public function __construct(string $jsonBody)
    {
        $this->componentClass = Milestone::class;
        parent::__construct($jsonBody);
    }
}
