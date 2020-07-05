<?php
declare(strict_types = 1);

namespace LarsNieuwenhuizen\ClubhouseConnector\Component\Domain\Model;

use LarsNieuwenhuizen\ClubhouseConnector\Component\ComponentResponseBody;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Stories\Domain\Model\Story;

final class StoriesCollection extends ComponentCollection
{

    public function addComponent(ComponentResponseBody $component): void
    {
        if ($component instanceof Story) {
            parent::addComponent($component);
        }
        throw new \DomainException('Only stories can be added in this collection');
    }
}
