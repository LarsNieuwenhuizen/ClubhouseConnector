<?php
declare(strict_types=1);

namespace LarsNieuwenhuizen\ClubhouseConnector\Component\Epics\Http;

use LarsNieuwenhuizen\ClubhouseConnector\Component\AbstractResponse;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Domain\Model\ComponentCollection;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Epics\Domain\Model\Epic;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Epics\Domain\Model\EpicCollection;

final class ListEpicsResponse extends AbstractResponse
{

    protected function formatJsonResult(string $json): void
    {
        $data = \json_decode($json, true);
        $collection = new ComponentCollection();
        foreach ($data as $epic) {
            $epic = Epic::createFromResponseData($epic);
            $collection->addComponent($epic);
        }
        $this->body = $collection;
    }
}
