<?php
declare(strict_types=1);

namespace LarsNieuwenhuizen\ClubhouseConnector\Component\Domain\Model;

use ArrayObject;
use Countable;
use IteratorAggregate;
use LarsNieuwenhuizen\ClubhouseConnector\Component\ComponentResponseBody;
use Traversable;

final class ComponentCollection implements IteratorAggregate, ComponentResponseBody, Countable
{

    private ArrayObject $components;

    public function __construct()
    {
        $this->components = new ArrayObject();
    }

    public function addComponent(ComponentResponseBody $component): void
    {
        $this->components->append($component);
    }

    public function getIterator(): Traversable
    {
        foreach ($this->getComponents() as $key => $value) {
            yield $key => $value;
        }
    }

    public function count(): int
    {
        return $this->getComponents()->count();
    }

    public function getComponents(): ArrayObject
    {
        return $this->components;
    }
}
