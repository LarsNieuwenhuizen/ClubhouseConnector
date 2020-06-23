<?php
declare(strict_types = 1);

namespace LarsNieuwenhuizen\ClubhouseConnector\Component\Epics\Domain\Model;

use DateTime;
use LarsNieuwenhuizen\ClubhouseConnector\Component\ComponentResponseBody;
use LarsNieuwenhuizen\ClubhouseConnector\Component\CreateableComponent;

final class Epic implements ComponentResponseBody, CreateableComponent
{

    private string $appUrl;
    private bool $archived;
    private bool $completed;
    private ?DateTime $completedAt = null;
    private ?DateTime $completedAtOverride = null;
    private DateTime $createdAt;
    private ?DateTime $deadline;
    private string $description;
    private string $entityType;
    private ?int $epicStateId = null;
    private ?string $externalId = null;
    private array $externalTickets = [];
    private array $followerIds = [];
    private array $groupMentionIds = [];
    private int $id;
    private array $labels = [];
    private array $memberMentionIds = [];
    private array $mentionIds = [];
    private ?int $milestoneId = null;
    private string $name;
    private array $ownerIds = [];
    private ?DateTime $plannedStartDate = null;
    private ?int $position;
    private array $projectIds = [];
    private string $requestedById;
    private bool $started;
    private ?DateTime $startedAt = null;
    private ?DateTime $startedAtOverride = null;
    private string $state;
    private array $stats = [];
    private ?DateTime $updated = null;

    public static function createFromResponseData(array $values): Epic
    {
        $object = new static();
        $object->appUrl = $values['app_url'];
        $object->archived = $values['archived'];
        $object->completed = $values['completed'];
        if (isset($values['completed_at']) && $values['completed_at'] !== null) {
            $object->completedAt = DateTime::createFromFormat('Y-m-d\TH:i:s\Z', (string)$values['completed_at']);
        }
        if (isset($values['completed_at_override']) && $values['completed_at_override'] !== null) {
            $object->completedAtOverride = DateTime::createFromFormat('Y-m-d\TH:i:s\Z', (string)$values['completed_at_override']);
        }
        $object->createdAt = DateTime::createFromFormat('Y-m-d\TH:i:s\Z', (string)$values['created_at']);
        if (isset($values['deadline']) && $values['deadline'] !== null) {
            $object->deadline = DateTime::createFromFormat('Y-m-d\TH:i:s\Z', (string)$values['deadline']);
        }
        $object->description = $values['description'] ?? '';
        $object->entityType = $values['entity_type'] ?? '';
        $object->epicStateId = $values['epic_state_id'] ?? null;
        $object->externalId = $values['external_id'] ?? null;
        $object->externalTickets = $values['external_tickets'] ?? [];
        $object->followerIds = $values['follower_ids'] ?? [];
        $object->groupMentionIds = $values['group_mention_ids'] ?? [];
        $object->id = $values['id'];
        $object->labels = $values['labels'] ?? [];
        $object->memberMentionIds = $values['member_mention_ids'] ?? [];
        $object->mentionIds = $values['mention_ids'] ?? [];
        $object->milestoneId = $values['milestone_id'] ?? null;
        $object->name = $values['name'];
        $object->ownerIds = $values['owner_ids'] ?? [];
        if (isset($values['planned_start_date']) && $values['planned_start_date'] !== null) {
            $object->plannedStartDate = DateTime::createFromFormat('Y-m-d\TH:i:s\Z', (string)$values['planned_start_date']);
        }
        $object->position = $values['position'] ?? null;
        $object->projectIds = $values['project_ids'] ?? [];
        $object->requestedById = $values['requested_by_id'];
        $object->started = $values['started'];
        if (isset($values['started_at']) && $values['started_at'] !== null) {
            $object->startedAt = DateTime::createFromFormat('Y-m-d\TH:i:s\Z', (string)$values['started_at']);
        }
        if (isset($values['started_at_override']) && $values['started_at_override'] !== null) {
            $object->startedAtOverride = DateTime::createFromFormat('Y-m-d\TH:i:s\Z', (string)$values['started_at_override']);
        }
        $object->state = $values['state'];
        $object->stats = $values['stats'] ?? [];
        if (isset($values['updated']) && $values['updated'] !== null) {
            $object->updated = DateTime::createFromFormat('Y-m-d\TH:i:s\Z', (string)$values['updated']);;
        }
        return $object;
    }

    public function getAppUrl(): string
    {
        return $this->appUrl;
    }

    public function getArchived(): bool
    {
        return $this->archived;
    }

    public function getCompleted(): bool
    {
        return $this->completed;
    }

    public function getCompletedAt(): ?DateTime
    {
        return $this->completedAt;
    }

    public function getCompletedAtOverride(): ?DateTime
    {
        return $this->completedAtOverride;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function getDeadline(): ?DateTime
    {
        return $this->deadline;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getEntityType(): string
    {
        return $this->entityType;
    }

    public function getEpicStateId(): int
    {
        return $this->epicStateId;
    }

    public function getExternalId(): string
    {
        return $this->externalId;
    }

    public function getExternalTickets(): array
    {
        return $this->externalTickets;
    }

    public function getFollowerIds(): array
    {
        return $this->followerIds;
    }

    public function getGroupMentionIds(): array
    {
        return $this->groupMentionIds;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getLabels(): array
    {
        return $this->labels;
    }

    public function getMemberMentionIds(): array
    {
        return $this->memberMentionIds;
    }

    public function getMentionIds(): array
    {
        return $this->mentionIds;
    }

    public function getMilestoneId(): int
    {
        return $this->milestoneId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getOwnerIds(): array
    {
        return $this->ownerIds;
    }

    public function getPlannedStartDate(): ?DateTime
    {
        return $this->plannedStartDate;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function getProjectIds(): array
    {
        return $this->projectIds;
    }

    public function getRequestedById(): string
    {
        return $this->requestedById;
    }

    public function getStarted(): bool
    {
        return $this->started;
    }

    public function getStartedAt(): ?DateTime
    {
        return $this->startedAt;
    }

    public function getStartedAtOverride(): ?DateTime
    {
        return $this->startedAtOverride;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function getStats(): array
    {
        return $this->stats;
    }

    public function getUpdated(): ?DateTime
    {
        return $this->updated;
    }

    public function setCompletedAtOverride(?DateTime $completedAtOverride): Epic
    {
        $this->completedAtOverride = $completedAtOverride;
        return $this;
    }

    public function setCreatedAt(DateTime $createdAt): Epic
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function setDeadline(?DateTime $deadline): Epic
    {
        $this->deadline = $deadline;
        return $this;
    }

    public function setDescription(string $description): Epic
    {
        $this->description = $description;
        return $this;
    }

    public function setEpicStateId(?int $epicStateId): Epic
    {
        $this->epicStateId = $epicStateId;
        return $this;
    }

    public function setExternalId(?string $externalId): Epic
    {
        $this->externalId = $externalId;
        return $this;
    }

    public function setFollowerIds(array $followerIds): Epic
    {
        $this->followerIds = $followerIds;
        return $this;
    }

    public function setLabels(array $labels): Epic
    {
        $this->labels = $labels;
        return $this;
    }

    public function setMilestoneId(?int $milestoneId): Epic
    {
        $this->milestoneId = $milestoneId;
        return $this;
    }

    public function setName(string $name): Epic
    {
        $this->name = $name;
        return $this;
    }

    public function setOwnerIds(array $ownerIds): Epic
    {
        $this->ownerIds = $ownerIds;
        return $this;
    }

    public function setPlannedStartDate(?DateTime $plannedStartDate): Epic
    {
        $this->plannedStartDate = $plannedStartDate;
        return $this;
    }

    public function setRequestedById(string $requestedById): Epic
    {
        $this->requestedById = $requestedById;
        return $this;
    }

    public function setStartedAtOverride(?DateTime $startedAtOverride): Epic
    {
        $this->startedAtOverride = $startedAtOverride;
        return $this;
    }

    public function setUpdated(?DateTime $updated): Epic
    {
        $this->updated = $updated;
        return $this;
    }

    public function toJsonForCreation(): string
    {
        return \json_encode([
            'name' => $this->getName()
        ]);
    }
}
