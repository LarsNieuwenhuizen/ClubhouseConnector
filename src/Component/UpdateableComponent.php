<?php
declare(strict_types = 1);

namespace LarsNieuwenhuizen\ClubhouseConnector\Component;

interface UpdateableComponent
{

    public function toJsonForUpdate(): string;
}
