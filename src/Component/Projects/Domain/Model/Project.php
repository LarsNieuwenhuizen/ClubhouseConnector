<?php
declare(strict_types=1);

namespace LarsNieuwenhuizen\ClubhouseConnector\Component\Projects\Domain\Model;

use DateTime;
use LarsNieuwenhuizen\ClubhouseConnector\Component\ComponentResponseBody;
use LarsNieuwenhuizen\ClubhouseConnector\Component\CreateableComponent;
use LarsNieuwenhuizen\ClubhouseConnector\Component\UpdateableComponent;
use LarsNieuwenhuizen\ClubhouseConnector\Connector;

final class Project implements ComponentResponseBody, UpdateableComponent, CreateableComponent
{

    private int $id;

    private string $appUrl = '';

    private string $abbreviation = '';

    private bool $archived = false;

    private string $color = '';

    private ?DateTime $createAt = null;

    private string $description = '';

    private string $externalId = '';

    private array $followerIds = [];

    private int $iterationLength = 2;

    private string $name;

    private ?DateTime $startTime = null;

    private int $teamId = 0;

    private ?DateTime $updatedAt = null;

    private ?DateTime $createdAt = null;

    private ?int $daysToThermometer = null;

    private string $entityType = '';

    private bool $showThermometer = false;

    private array $stats = [];

    private bool $changeTeamId = false;

    public static function createFromResponseData(array $values): Project
    {
        $object = new static();
        $object->appUrl = $values['app_url'];
        $object->abbreviation = $values['abbreviation'] ?? '';
        $object->archived = $values['archived'] ?? false;
        $object->color = $values['color'] ?? '';
        $object->createdAt = DateTime::createFromFormat(Connector::DATE_TIME_FORMAT, $values['created_at']);
        $object->daysToThermometer = $values['days_to_thermometer'] ?? null;
        $object->description = $values['description'] ?? '';
        $object->entityType = $values['entity_type'] ?? '';
        $object->externalId = $values['external_id'] ?? '';
        $object->followerIds = $values['follower_ids'] ?? [];
        $object->id = $values['id'];
        $object->iterationLength = $values['iteration_length'];
        $object->name = $values['name'];
        $object->showThermometer = $values['show_thermometer'] ?? false;

        if (isset($values['start_time']) && $values['start_time'] !== '') {
            $object->startTime = DateTime::createFromFormat(Connector::DATE_TIME_FORMAT, $values['start_time']);
        }
        $object->stats = $values['stats'] ?? [];
        $object->teamId = $values['team_id'];

        if (isset($values['updated_at']) && $values['updated_at'] !== '') {
            $object->updatedAt = DateTime::createFromFormat(Connector::DATE_TIME_FORMAT, $values['updated_at']);
        }

        return $object;
    }

    public function toArrayForCreation(): array
    {
        $data = [
            'name' => $this->getName(),
            'team_id' => $this->getTeamId(),
            'abbreviation' => $this->getAbbreviation(),
            'color' => $this->getColor(),
            'description' => $this->getDescription(),
            'external_id' => $this->getExternalId(),
            'follower_ids' => $this->getFollowerIds(),
            'iteration_length' => $this->getIterationLength()
        ];

        if ($this->getCreatedAt() instanceof DateTime) {
            $data['created_at'] = $this->getCreatedAt()->format(Connector::DATE_TIME_FORMAT);
        }
        if ($this->getStartTime() instanceof DateTime) {
            $data['start_time'] = $this->getStartTime()->format(Connector::DATE_TIME_FORMAT);
        }
        if ($this->getUpdatedAt() instanceof DateTime) {
            $data['updated_at'] = $this->getUpdatedAt()->format(Connector::DATE_TIME_FORMAT);
        }

        return $data;
    }

    public function toArrayForUpdate(): array
    {
        $data = [
            'name' => $this->getName(),
            'abbreviation' => $this->getAbbreviation(),
            'archived' => $this->getArchived(),
            'color' => $this->getColor(),
            'description' => $this->getDescription(),
            'follower_ids' => $this->getFollowerIds(),
            'show_thermometer' => $this->getShowThermometer()
        ];

        if ($this->changeTeamId === true) {
            $data['team_id'] = $this->getTeamId();
        }
        if ($this->getDaysToThermometer() !== null) {
            $data['days_to_thermometer'] = $this->getDaysToThermometer();
        }

        return $data;
    }

    public function getAbbreviation(): string
    {
        return $this->abbreviation;
    }

    public function setAbbreviation(string $abbreviation): Project
    {
        $this->abbreviation = $abbreviation;
        return $this;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function setColor(string $color): Project
    {
        $this->color = $color;
        return $this;
    }

    public function getCreateAt(): ?DateTime
    {
        return $this->createAt;
    }

    public function setCreateAt(?DateTime $createAt): Project
    {
        $this->createAt = $createAt;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): Project
    {
        $this->description = $description;
        return $this;
    }

    public function getExternalId(): string
    {
        return $this->externalId;
    }

    public function setExternalId(string $externalId): Project
    {
        $this->externalId = $externalId;
        return $this;
    }

    public function getFollowerIds(): array
    {
        return $this->followerIds;
    }

    public function setFollowerIds(array $followerIds): Project
    {
        $this->followerIds = $followerIds;
        return $this;
    }

    public function getIterationLength(): int
    {
        return $this->iterationLength;
    }

    public function setIterationLength(int $iterationLength): Project
    {
        $this->iterationLength = $iterationLength;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Project
    {
        $this->name = $name;
        return $this;
    }

    public function getStartTime(): ?DateTime
    {
        return $this->startTime;
    }

    public function setStartTime(?DateTime $startTime): Project
    {
        $this->startTime = $startTime;
        return $this;
    }

    public function getTeamId(): int
    {
        return $this->teamId;
    }

    public function setTeamId(int $teamId): Project
    {
        if ($this->getTeamId() !== $teamId) {
            $this->changeTeamId = true;
        }
        $this->teamId = $teamId;
        return $this;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTime $updatedAt): Project
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): Project
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getAppUrl(): string
    {
        return $this->appUrl;
    }

    public function setAppUrl(string $appUrl): Project
    {
        $this->appUrl = $appUrl;
        return $this;
    }

    public function getArchived(): bool
    {
        return $this->archived;
    }

    public function setArchived(bool $archived): Project
    {
        $this->archived = $archived;
        return $this;
    }

    public function getDaysToThermometer(): ?int
    {
        return $this->daysToThermometer;
    }

    public function setDaysToThermometer(?int $daysToThermometer): Project
    {
        $this->daysToThermometer = $daysToThermometer;
        return $this;
    }

    public function getEntityType(): string
    {
        return $this->entityType;
    }

    public function setEntityType(string $entityType): Project
    {
        $this->entityType = $entityType;
        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Project
    {
        $this->id = $id;
        return $this;
    }

    public function getShowThermometer(): bool
    {
        return $this->showThermometer;
    }

    public function setShowThermometer(bool $showThermometer): Project
    {
        $this->showThermometer = $showThermometer;
        return $this;
    }

    public function getStats(): array
    {
        return $this->stats;
    }

    public function setStats(array $stats): Project
    {
        $this->stats = $stats;
        return $this;
    }
}
