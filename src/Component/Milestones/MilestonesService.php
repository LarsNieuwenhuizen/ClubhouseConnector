<?php
declare(strict_types=1);

namespace LarsNieuwenhuizen\ClubhouseConnector\Component\Milestones;

use LarsNieuwenhuizen\ClubhouseConnector\Component\AbstractComponentService;
use LarsNieuwenhuizen\ClubhouseConnector\Component\ComponentService;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Milestones\Domain\Model\Milestone;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Milestones\Http\GetMilestoneResponse;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Milestones\Http\ListMilestonesResponse;

final class MilestonesService extends AbstractComponentService implements ComponentService
{

    protected string $apiPath = 'milestones';

    protected string $componentClass = Milestone::class;

    protected string $getResponseClass = GetMilestoneResponse::class;

    protected string $listResponseClass = ListMilestonesResponse::class;
}
