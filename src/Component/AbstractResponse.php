<?php
declare(strict_types = 1);

namespace LarsNieuwenhuizen\ClubhouseConnector\Component;

abstract class AbstractResponse
{

    protected ComponentResponseBody $body;

    abstract protected function formatJsonResult(string $jsonResult): void;

    public function __construct(string $jsonBody)
    {
        $this->formatJsonResult($jsonBody);
    }

    public function getBody(): ComponentResponseBody
    {
        return $this->body;
    }
}
