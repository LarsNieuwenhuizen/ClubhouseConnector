<?php
declare(strict_types=1);

namespace LarsNieuwenhuizen\ClubhouseConnector\Component\Epics\Http;

use LarsNieuwenhuizen\ClubhouseConnector\Component\AbstractResponse;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Epics\Domain\Model\Epic;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Epics\Domain\Model\EpicCollection;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Response\ComponentCollectionResponseTrait;

final class ListEpicsResponse extends AbstractResponse
{

    use ComponentCollectionResponseTrait;

    public function __construct(string $jsonBody)
    {
        $this->componentClass = Epic::class;
        parent::__construct($jsonBody);
    }
}
