<?php
declare(strict_types = 1);

namespace LarsNieuwenhuizen\ClubhouseConnector\Component\Milestones\Domain\Model;

use DateTime;
use DateTimeZone;
use LarsNieuwenhuizen\ClubhouseConnector\Component\ComponentResponseBody;
use LarsNieuwenhuizen\ClubhouseConnector\Component\CreateableComponent;
use LarsNieuwenhuizen\ClubhouseConnector\Component\UpdateableComponent;
use LarsNieuwenhuizen\ClubhouseConnector\Connector;

final class Milestone implements ComponentResponseBody, UpdateableComponent, CreateableComponent
{

    private string $appUrl;
    private array $categories = [];
    private bool $completed = false;
    private ?DateTime $completedAt = null;
    private ?DateTime $completedAtOverride = null;
    private ?DateTime $createdAt = null;
    private string $description = '';
    private string $entityType = '';
    private int $id;
    private string $name;
    private ?int $position = null;
    private bool $started = false;
    private ?DateTime $startedAt = null;
    private ?DateTime $startedAtOverride = null;
    private array $stats = [];
    private ?DateTime $updatedAt;
    private DateTimeZone $defaultDateTimeZone;
    private string $state = 'to do';

    public function __construct()
    {
        $this->defaultDateTimeZone = new DateTimeZone('Europe/Amsterdam');
    }

    public static function createFromResponseData(array $values): Milestone
    {
        $object = new static();
        $object->appUrl = $values['app_url'];
        $object->categories = $values['categories'] ?? [];
        $object->completed = $values['completed'] ?? false;

        if (isset($values['completed_at']) && $values['completed_at'] !== null) {
            $object->completedAt = DateTime::createFromFormat(
                Connector::DATE_TIME_FORMAT,
                $values['completed_at'],
                $object->defaultDateTimeZone
            );
        }
        if (isset($values['completed_at_override']) && $values['completed_at_override'] !== null) {
            $object->completedAtOverride = DateTime::createFromFormat(
                Connector::DATE_TIME_FORMAT,
                $values['completed_at_override'],
                $object->defaultDateTimeZone
            );
        }
        $object->createdAt = DateTime::createFromFormat(
            Connector::DATE_TIME_FORMAT,
            $values['created_at'],
            $object->defaultDateTimeZone
        );
        $object->description = $values['description'] ?? '';
        $object->entityType = $values['entity_type'] ?? '';
        $object->id = $values['id'];
        $object->name = $values['name'];
        $object->position = $values['position'] ?? null;
        $object->started = $values['started'] ?? false;
        if (isset($values['started_at']) && $values['started_at'] !== null) {
            $object->startedAt = DateTime::createFromFormat(
                Connector::DATE_TIME_FORMAT,
                $values['started_at'],
                $object->defaultDateTimeZone
            );
        }
        if (isset($values['started_at_override']) && $values['started_at_override'] !== null) {
            $object->startedAtOverride = DateTime::createFromFormat(
                Connector::DATE_TIME_FORMAT,
                $values['started_at_override'],
                $object->defaultDateTimeZone
            );
        }
        $object->state = $values['state'];
        $object->stats = $values['stats'] ?? [];
        if (isset($values['updated_at']) && $values['updated_at'] !== null) {
            $object->updatedAt = DateTime::createFromFormat(
                Connector::DATE_TIME_FORMAT,
                $values['updated_at'],
                $object->defaultDateTimeZone
            );;
        }

        return $object;
    }

    public function toJsonForCreation(): string
    {
        // TODO: Implement toJsonForCreation() method.
    }

    public function toJsonForUpdate(): string
    {
        // TODO: Implement toJsonForUpdate() method.
    }

    public function getAppUrl(): string
    {
        return $this->appUrl;
    }

    public function setAppUrl(string $appUrl): Milestone
    {
        $this->appUrl = $appUrl;
        return $this;
    }

    public function getCategories(): array
    {
        return $this->categories;
    }

    public function setCategories(array $categories): Milestone
    {
        $this->categories = $categories;
        return $this;
    }

    public function getCompleted(): bool
    {
        return $this->completed;
    }

    public function setCompleted(bool $completed): Milestone
    {
        $this->completed = $completed;
        return $this;
    }

    public function getCompletedAt(): ?DateTime
    {
        return $this->completedAt;
    }

    public function setCompletedAt(?DateTime $completedAt): Milestone
    {
        $this->completedAt = $completedAt;
        return $this;
    }

    public function getCompletedAtOverride(): ?DateTime
    {
        return $this->completedAtOverride;
    }

    public function setCompletedAtOverride(?DateTime $completedAtOverride): Milestone
    {
        $this->completedAtOverride = $completedAtOverride;
        return $this;
    }

    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?DateTime $createdAt): Milestone
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): Milestone
    {
        $this->description = $description;
        return $this;
    }

    public function getEntityType(): ?string
    {
        return $this->entityType;
    }

    public function setEntityType(string $entityType): Milestone
    {
        $this->entityType = $entityType;
        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Milestone
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Milestone
    {
        $this->name = $name;
        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(?int $position): Milestone
    {
        $this->position = $position;
        return $this;
    }

    public function getStarted(): bool
    {
        return $this->started;
    }

    public function setStarted(bool $started): Milestone
    {
        $this->started = $started;
        return $this;
    }

    public function getStats(): array
    {
        return $this->stats;
    }

    public function setStats(array $stats): Milestone
    {
        $this->stats = $stats;
        return $this;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTime $updatedAt): Milestone
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getStartedAt(): ?DateTime
    {
        return $this->startedAt;
    }

    public function setStartedAt(?DateTime $startedAt): Milestone
    {
        $this->startedAt = $startedAt;
        return $this;
    }

    public function getStartedAtOverride(): ?DateTime
    {
        return $this->startedAtOverride;
    }

    public function setStartedAtOverride(?DateTime $startedAtOverride): Milestone
    {
        $this->startedAtOverride = $startedAtOverride;
        return $this;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function setState(string $state): Milestone
    {
        $this->state = $state;
        return $this;
    }
}
