<?php
declare(strict_types = 1);

namespace LarsNieuwenhuizen\ClubhouseConnector\Component\Projects\Http;

use LarsNieuwenhuizen\ClubhouseConnector\Component\AbstractResponse;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Projects\Domain\Model\Project;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Response\ComponentCollectionResponseTrait;

final class ListProjectsResponse extends AbstractResponse
{

    use ComponentCollectionResponseTrait;

    public function __construct(string $jsonBody)
    {
        $this->componentClass = Project::class;
        parent::__construct($jsonBody);
    }
}
