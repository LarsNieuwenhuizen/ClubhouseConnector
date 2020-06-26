<?php
declare(strict_types = 1);

namespace LarsNieuwenhuizen\ClubhouseConnector\Component\Projects;

use LarsNieuwenhuizen\ClubhouseConnector\Component\AbstractComponentService;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Projects\Domain\Model\Project;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Projects\Http\GetProjectResponse;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Projects\Http\ListProjectsResponse;

final class ProjectsService extends AbstractComponentService
{

    protected string $apiPath = 'projects';

    protected string $componentName = 'project';

    protected string $componentClass = Project::class;

    protected string $getResponseClass = GetProjectResponse::class;

    protected string $listResponseClass = ListProjectsResponse::class;
}
