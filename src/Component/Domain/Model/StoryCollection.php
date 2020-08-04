<?php
declare(strict_types = 1);

namespace LarsNieuwenhuizen\ClubhouseConnector\Component\Domain\Model;

use LarsNieuwenhuizen\ClubhouseConnector\Component\BulkCreateableComponentCollection;
use LarsNieuwenhuizen\ClubhouseConnector\Component\ComponentResponseBody;
use LarsNieuwenhuizen\ClubhouseConnector\Component\Stories\Domain\Model\Story;

final class StoryCollection extends ComponentCollection implements BulkCreateableComponentCollection
{

    public function addComponent(ComponentResponseBody $component): self
    {
        if ($component instanceof Story) {
            parent::addComponent($component);
            return $this;
        }
        throw new \DomainException('Only stories can be added in this collection');
    }

    public function toArrayForBulkCreation(): array
    {
        $data = ['stories' => []];
        /** @var Story $story */
        foreach ($this->getComponents() as $story) {
            $data['stories'][] = $story->toArrayForCreation();
        }
        return $data;
    }
}
