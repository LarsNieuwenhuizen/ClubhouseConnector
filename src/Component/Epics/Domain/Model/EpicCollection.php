<?php
declare(strict_types = 1);

namespace LarsNieuwenhuizen\ClubhouseConnector\Component\Epics\Domain\Model;

use Countable;
use IteratorAggregate;
use LarsNieuwenhuizen\ClubhouseConnector\Component\ComponentResponseBody;
use Traversable;

final class EpicCollection implements IteratorAggregate, Countable, ComponentResponseBody
{

    /**
     * @var Epic[]
     */
    private array $epics;

    public function addEpic(Epic $epic)
    {
        $this->epics[] = $epic;
    }

    public function getIterator(): Traversable
    {
        foreach ($this->epics as $key => $value) {
            yield $key => $value;
        }
    }

    public function count(): int
    {
        return \count($this->epics);
    }
}
