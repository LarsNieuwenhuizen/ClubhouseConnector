<?php
declare(strict_types = 1);

namespace LarsNieuwenhuizen\ClubhouseConnector\Exception\Connector;

use Exception;

final class UndefinedMethodException extends Exception
{

    protected $message = 'This method does not exist';
}
