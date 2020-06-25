<?php
declare(strict_types=1);

namespace LarsNieuwenhuizen\ClubhouseConnector\Component\Milestones\Domain\Model;

use Countable;
use IteratorAggregate;
use LarsNieuwenhuizen\ClubhouseConnector\Component\ComponentResponseBody;
use Traversable;

final class MilestoneCollection implements IteratorAggregate, Countable, ComponentResponseBody
{

    /**
     * @var Milestone[]
     */
    private array $milestones;

    public function addMilestone(Milestone $milestone)
    {
        $this->milestones[] = $milestone;
    }

    public function getIterator(): Traversable
    {
        foreach ($this->milestones as $key => $value) {
            yield $key => $value;
        }
    }

    public function count(): int
    {
        return \count($this->milestones);
    }
}
