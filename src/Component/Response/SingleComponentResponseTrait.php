<?php
declare(strict_types = 1);

namespace LarsNieuwenhuizen\ClubhouseConnector\Component\Response;

trait SingleComponentResponseTrait
{

    protected string $componentClass;

    protected function formatJsonResult(string $json): void
    {
        $data = \json_decode($json, true);
        $component = $this->componentClass::createFromResponseData($data);
        $this->body = $component;
    }
}
