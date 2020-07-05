<?php
declare(strict_types = 1);

namespace LarsNieuwenhuizen\ClubhouseConnector\Component;

interface BulkCreateableComponentCollection
{

    public function toArrayForBulkCreation(): array;
}
