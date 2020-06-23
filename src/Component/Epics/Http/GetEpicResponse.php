<?php
declare(strict_types = 1);

namespace LarsNieuwenhuizen\ClubhouseConnector\Component\Epics\Http;

use LarsNieuwenhuizen\ClubhouseConnector\Component\AbstractResponse;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Epics\Domain\Model\Epic;

final class GetEpicResponse extends AbstractResponse
{

    protected function formatJsonResult(string $json): void
    {
        $data = \json_decode($json, true);
        $epic = Epic::createFromResponseData($data);
        $this->body = $epic;
    }
}
