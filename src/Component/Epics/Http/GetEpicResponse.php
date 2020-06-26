<?php
declare(strict_types = 1);

namespace LarsNieuwenhuizen\ClubhouseConnector\Component\Epics\Http;

use LarsNieuwenhuizen\ClubhouseConnector\Component\AbstractResponse;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Epics\Domain\Model\Epic;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Response\SingleComponentResponseTrait;

final class GetEpicResponse extends AbstractResponse
{

    use SingleComponentResponseTrait;

    public function __construct(string $jsonBody)
    {
        $this->componentClass = Epic::class;
        parent::__construct($jsonBody);
    }
}
