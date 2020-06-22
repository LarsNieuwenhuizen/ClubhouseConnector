<?php
declare(strict_types=1);

namespace LarsNieuwenhuizen\ClubhouseConnector\Exception\Connector;

use Exception;

class ConnectorConstructionException extends Exception
{

    protected $message = 'Something went wrong while constructing the connector';
}
