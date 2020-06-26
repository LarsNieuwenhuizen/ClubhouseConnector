<?php
declare(strict_types = 1);

namespace LarsNieuwenhuizen\ClubhouseConnector\Component\Response;

use LarsNieuwenhuizen\ClubhouseConnector\Component\Domain\Model\ComponentCollection;

trait ComponentCollectionResponseTrait
{

    protected string $componentClass;

    protected function formatJsonResult(string $jsonResult): void
    {
        $data = \json_decode($jsonResult, true);
        $collection = new ComponentCollection();
        foreach ($data as $milestone) {
            $milestone = $this->componentClass::createFromResponseData($milestone);
            $collection->addComponent($milestone);
        }
        $this->body = $collection;
    }
}
