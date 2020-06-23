<?php
declare(strict_types = 1);

namespace LarsNieuwenhuizen\ClubhouseConnector\Component;

interface CreateableComponent
{

    public function toJsonForCreation(): string;
}
