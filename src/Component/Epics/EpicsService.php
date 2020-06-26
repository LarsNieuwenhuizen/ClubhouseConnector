<?php
declare(strict_types=1);

namespace LarsNieuwenhuizen\ClubhouseConnector\Component\Epics;

use LarsNieuwenhuizen\ClubhouseConnector\Component\AbstractComponentService;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Epics\Domain\Model\Epic;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Epics\Http\GetEpicResponse;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Epics\Http\ListEpicsResponse;

final class EpicsService extends AbstractComponentService
{

    protected string $apiPath = 'epics';

    protected string $listResponseClass = ListEpicsResponse::class;

    protected string $getResponseClass = GetEpicResponse::class;

    protected string $componentClass = Epic::class;

    protected string $componentName = 'epic';
}
