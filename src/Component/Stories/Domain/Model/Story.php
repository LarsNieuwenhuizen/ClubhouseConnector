<?php
declare(strict_types = 1);

namespace LarsNieuwenhuizen\ClubhouseConnector\Component\Stories\Domain\Model;

use DateTime;
use LarsNieuwenhuizen\ClubhouseConnector\Component\ComponentResponseBody;
use LarsNieuwenhuizen\ClubhouseConnector\Component\CreateableComponent;
use LarsNieuwenhuizen\ClubhouseConnector\Component\UpdateableComponent;
use LarsNieuwenhuizen\ClubhouseConnector\Connector;

final class Story implements ComponentResponseBody, UpdateableComponent, CreateableComponent
{

    const STORY_TYPE_CHORE = 'chore';
    const STORY_TYPE_BUG = 'bug';
    const STORY_TYPE_FEATURE = 'feature';

    private string $appUrl = '';
    private ?int $afterStory = null;
    private bool $archived = false;
    private ?int $beforeStory = null;
    private bool $blocked = false;
    private bool $blocker = false;
    private array $branches = [];
    private array $comments = [];
    private array $commits = [];
    private ?int $cycleTime = null;
    private bool $completed = false;
    private ?DateTime $completedAt = null;
    private ?DateTime $completedAtOverride = null;
    private ?DateTime $createdAt = null;
    private ?DateTime $deadline = null;
    private string $description = '';
    private string $entityType = '';
    private ?int $epicId = null;
    private ?int $estimate = null;
    private string $externalId = '';
    private array $externalLinks = [];
    private array $externalTickets = [];
    private array $files = [];
    private array $fileIds = [];
    private array $followerIds = [];
    private array $groupMentionIds = [];
    private int $id;
    private ?int $iterationId = null;
    private array $labels = [];
    private ?int $leadTime = null;
    private array $linkedFileIds = [];
    private array $linkedFiles = [];
    private array $memberMentionIds = [];
    private array $mentionIds = [];
    private ?DateTime $movedAt = null;
    private string $name;
    private array $ownerIds = [];
    private ?int $position = null;
    private array $previousIterationIds = [];
    private int $projectId;
    private array $pullRequests = [];
    private ?string $requestedById = null;
    private bool $started = false;
    private ?DateTime $startedAt = null;
    private ?DateTime $startedAtOverride = null;
    private array $stats = [];
    private array $storyLinks = [];
    private string $storyType = self::STORY_TYPE_CHORE;
    private array $tasks = [];
    private ?DateTime $updatedAt = null;
    private ?int $workflowStateId = null;

    public static function createFromResponseData(array $values): Story
    {
        $object = new static();
        $object->appUrl = $values['app_url'];
        $object->archived = $values['archived'];
        $object->blocked = $values['blocked'];
        $object->blocker = $values['blocker'];
        $object->branches = $values['branches'] ?? [];
        $object->comments = $values['comments'] ?? [];
        $object->commits = $values['commits'] ?? [];
        $object->completed = $values['completed'] ?? false;
        $object->cycleTime = $values['cycle_time'] ?? null;
        $object->description = $values['description'] ?? '';
        $object->entityType = $values['entity_type'] ?? '';
        $object->epicId = $values['epic_id'] ?? null;
        $object->estimate = $values['estimate'] ?? null;
        $object->externalId = $values['external_id'] ?? '';
        $object->externalLinks = $values['external_links'] ?? [];
        $object->externalTickets = $values['external_tickets'] ?? [];
        $object->files = $values['files'] ?? [];
        $object->followerIds = $values['follower_ids'] ?? [];
        $object->groupMentionIds = $values['group_mention_ids'] ?? [];
        $object->id = $values['id'];
        $object->iterationId = $values['iteration_id'] ?? null;
        $object->labels = $values['labels'] ?? [];
        $object->leadTime = $values['lead_time'] ?? null;
        $object->linkedFiles = $values['linked_files'] ?? [];
        $object->memberMentionIds = $values['member_mention_ids'] ?? [];
        $object->mentionIds = $values['mention_ids'] ?? [];
        $object->name = $values['name'];
        $object->ownerIds = $values['owner_ids'];
        $object->position = $values['position'] ?? null;
        $object->previousIterationIds = $values['previous_iteration_ids'] ?? [];
        $object->projectId = $values['project_id'];
        $object->pullRequests = $values['pull_requests'] ?? [];
        $object->requestedById = $values['requests_by_id'] ?? null;
        $object->started = $values['started'] ?? false;
        $object->stats = $values['stats'] ?? [];
        $object->storyLinks = $values['story_links'] ?? [];
        $object->storyType = $values['story_type'] ?? '';
        $object->tasks = $values['tasks'] ?? [];
        $object->workflowStateId = $values['workflow_state_id'] ?? null;

        if (isset($values['completed_at']) && $values['completed_at'] !== '') {
            $object->completedAt = DateTime::createFromFormat(Connector::DATE_TIME_FORMAT, $values['completed_at']);
        }
        if (isset($values['completed_at_override']) && $values['completed_at_override'] !== '') {
            $object->completedAtOverride = DateTime::createFromFormat(
                Connector::DATE_TIME_FORMAT,
                $values['completed_at_override']
            );
        }
        if (isset($values['created_at']) && $values['created_at'] !== '') {
            $object->createdAt = DateTime::createFromFormat(Connector::DATE_TIME_FORMAT, $values['created_at']);
        }
        if (isset($values['updated_at']) && $values['updated_at'] !== '') {
            $object->updatedAt = DateTime::createFromFormat(Connector::DATE_TIME_FORMAT, $values['updated_at']);
        }
        if (isset($values['deadline']) && $values['deadline'] !== '') {
            $object->deadline = DateTime::createFromFormat(Connector::DATE_TIME_FORMAT, $values['deadline']);
        }
        if (isset($values['moved_at']) && $values['moved_at'] !== '') {
            $object->movedAt = DateTime::createFromFormat(Connector::DATE_TIME_FORMAT, $values['moved_at']);
        }
        if (isset($values['started_at']) && $values['started_at'] !== '') {
            $object->startedAt = DateTime::createFromFormat(Connector::DATE_TIME_FORMAT, $values['started_at']);
        }
        if (isset($values['started_at_override']) && $values['started_at_override'] !== '') {
            $object->startedAtOverride = DateTime::createFromFormat(
                Connector::DATE_TIME_FORMAT,
                $values['started_at_override']
            );
        }
        return $object;
    }

    public function toArrayForCreation(): array
    {
        $data = [
            'archived' => $this->getArchived(),
            'comments' => $this->getComments(),
            'description' =>  $this->getDescription(),
            'epic_id' => $this->getEpicId(),
            'estimate' => $this->getEstimate(),
            'external_id' => $this->getExternalId(),
            'external_tickets' => $this->getExternalTickets(),
            'file_ids' => $this->getFileIds(),
            'follower_ids' => $this->getFollowerIds(),
            'iteration_id' => $this->getIterationId(),
            'labels' => $this->getLabels(),
            'linked_file_ids' => $this->getLinkedFileIds(),
            'name' => $this->getName(),
            'owner_ids' => $this->getOwnerIds(),
            'project_id' => $this->getProjectId(),
            'story_links' => $this->getStoryLinks(),
            'story_type' => $this->getStoryType(),
            'tasks' => $this->getTasks()
        ];

        if ($this->getCompletedAtOverride() !== null) {
            $data['completed_at_override'] = $this->getCompletedAtOverride()->format(Connector::DATE_TIME_FORMAT);
        }
        if ($this->getCreatedAt() !== null) {
            $data['created_at'] = $this->getCreatedAt()->format(Connector::DATE_TIME_FORMAT);
        }
        if ($this->getDeadline() !== null) {
            $data['deadline'] = $this->getDeadline()->format(Connector::DATE_TIME_FORMAT);
        }
        if ($this->getStartedAtOverride() !== null) {
            $data['started_at_override'] = $this->getStartedAtOverride()->format(Connector::DATE_TIME_FORMAT);
        }
        if ($this->getUpdatedAt() !== null) {
            $data['updated_at'] = $this->getUpdatedAt()->format(Connector::DATE_TIME_FORMAT);
        }
        return $data;
    }

    /**
     * @todo Implement branch_ids
     * @todo Implement commit_ids
     * @todo Implement pull_request_ids
     */
    public function toArrayForUpdate(): array
    {
        $data = [
            'archived' => $this->getArchived(),
            'description' => $this->getDescription(),
            'epic_id' => $this->getEpicId(),
            'estimate' => $this->getEstimate(),
            'file_ids' => $this->getFileIds(),
            'follower_ids' => $this->getFollowerIds(),
            'iteration_id' => $this->getIterationId(),
            'labels' => $this->getLabels(),
            'linked_file_ids' => $this->getLinkedFileIds(),
            'name' => $this->getName(),
            'owner_ids' => $this->getOwnerIds(),
            'project_id' => $this->getProjectId(),
            'started_at_override' => $this->getStartedAtOverride(),
            'story_type' => $this->getStoryType()
        ];
        if ($this->getAfterStory() !== null) {
            $data['after_id'] = $this->getAfterStory();
        }
        if ($this->getBeforeStory() !== null) {
            $data['before_id'] = $this->getBeforeStory();
        }
        if ($this->getCompletedAtOverride() !== null) {
            $data['completed_at_override'] = $this->getCompletedAtOverride()->format(Connector::DATE_TIME_FORMAT);
        }
        if ($this->getDeadline() !== null) {
            $data['deadline'] = $this->getDeadline()->format(Connector::DATE_TIME_FORMAT);
        }
        if ($this->getWorkflowStateId() !== null) {
            $data['workflow_state_id'] = $this->getWorkflowStateId();
        }

        return $data;
    }

    public function getArchived(): bool
    {
        return $this->archived;
    }

    public function setArchived(bool $archived): Story
    {
        $this->archived = $archived;
        return $this;
    }

    public function getBlocked(): bool
    {
        return $this->blocked;
    }

    public function setBlocked(bool $blocked): Story
    {
        $this->blocked = $blocked;
        return $this;
    }

    public function getBlocker(): bool
    {
        return $this->blocker;
    }

    public function setBlocker(bool $blocker): Story
    {
        $this->blocker = $blocker;
        return $this;
    }

    public function getBranches(): array
    {
        return $this->branches;
    }

    public function setBranches(array $branches): Story
    {
        $this->branches = $branches;
        return $this;
    }

    public function getComments(): array
    {
        return $this->comments;
    }

    public function setComments(array $comments): Story
    {
        $this->comments = $comments;
        return $this;
    }

    public function getCommits(): array
    {
        return $this->commits;
    }

    public function setCommits(array $commits): Story
    {
        $this->commits = $commits;
        return $this;
    }

    public function getCompleted(): bool
    {
        return $this->completed;
    }

    public function setCompleted(bool $completed): Story
    {
        $this->completed = $completed;
        return $this;
    }

    public function getCompletedAt(): ?DateTime
    {
        return $this->completedAt;
    }

    public function setCompletedAt(?DateTime $completedAt): Story
    {
        $this->completedAt = $completedAt;
        return $this;
    }

    public function getCompletedAtOverride(): ?DateTime
    {
        return $this->completedAtOverride;
    }

    public function setCompletedAtOverride(?DateTime $completedAtOverride): Story
    {
        $this->completedAtOverride = $completedAtOverride;
        return $this;
    }

    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?DateTime $createdAt): Story
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getDeadline(): ?DateTime
    {
        return $this->deadline;
    }

    public function setDeadline(?DateTime $deadline): Story
    {
        $this->deadline = $deadline;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): Story
    {
        $this->description = $description;
        return $this;
    }

    public function getEntityType(): string
    {
        return $this->entityType;
    }

    public function setEntityType(string $entityType): Story
    {
        $this->entityType = $entityType;
        return $this;
    }

    public function getEpicId(): ?int
    {
        return $this->epicId;
    }

    public function setEpicId(?int $epicId): Story
    {
        $this->epicId = $epicId;
        return $this;
    }

    public function getEstimate(): ?int
    {
        return $this->estimate;
    }

    public function setEstimate(?int $estimate): Story
    {
        $this->estimate = $estimate;
        return $this;
    }

    public function getExternalId(): string
    {
        return $this->externalId;
    }

    public function setExternalId(string $externalId): Story
    {
        $this->externalId = $externalId;
        return $this;
    }

    public function getExternalLinks(): array
    {
        return $this->externalLinks;
    }

    public function setExternalLinks(array $externalLinks): Story
    {
        $this->externalLinks = $externalLinks;
        return $this;
    }

    public function getExternalTickets(): array
    {
        return $this->externalTickets;
    }

    public function setExternalTickets(array $externalTickets): Story
    {
        $this->externalTickets = $externalTickets;
        return $this;
    }

    public function getFiles(): array
    {
        return $this->files;
    }

    public function setFiles(array $files): Story
    {
        $this->files = $files;
        return $this;
    }

    public function getFileIds(): array
    {
        return $this->fileIds;
    }

    public function setFileIds(array $fileIds): Story
    {
        $this->fileIds = $fileIds;
        return $this;
    }

    public function getFollowerIds(): array
    {
        return $this->followerIds;
    }

    public function setFollowerIds(array $followerIds): Story
    {
        $this->followerIds = $followerIds;
        return $this;
    }

    public function getGroupMentionIds(): array
    {
        return $this->groupMentionIds;
    }

    public function setGroupMentionIds(array $groupMentionIds): Story
    {
        $this->groupMentionIds = $groupMentionIds;
        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Story
    {
        $this->id = $id;
        return $this;
    }

    public function getIterationId(): ?int
    {
        return $this->iterationId;
    }

    public function setIterationId(?int $iterationId): Story
    {
        $this->iterationId = $iterationId;
        return $this;
    }

    public function getLabels(): array
    {
        return $this->labels;
    }

    public function setLabels(array $labels): Story
    {
        $this->labels = $labels;
        return $this;
    }

    public function getLeadTime(): ?int
    {
        return $this->leadTime;
    }

    public function setLeadTime(?int $leadTime): Story
    {
        $this->leadTime = $leadTime;
        return $this;
    }

    public function getLinkedFileIds(): array
    {
        return $this->linkedFileIds;
    }

    public function setLinkedFileIds(array $linkedFileIds): Story
    {
        $this->linkedFileIds = $linkedFileIds;
        return $this;
    }

    public function getLinkedFiles(): array
    {
        return $this->linkedFiles;
    }

    public function setLinkedFiles(array $linkedFiles): Story
    {
        $this->linkedFiles = $linkedFiles;
        return $this;
    }

    public function getMemberMentionIds(): array
    {
        return $this->memberMentionIds;
    }

    public function setMemberMentionIds(array $memberMentionIds): Story
    {
        $this->memberMentionIds = $memberMentionIds;
        return $this;
    }

    public function getMentionIds(): array
    {
        return $this->mentionIds;
    }

    public function setMentionIds(array $mentionIds): Story
    {
        $this->mentionIds = $mentionIds;
        return $this;
    }

    public function getMovedAt(): ?DateTime
    {
        return $this->movedAt;
    }

    public function setMovedAt(?DateTime $movedAt): Story
    {
        $this->movedAt = $movedAt;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Story
    {
        $this->name = $name;
        return $this;
    }

    public function getOwnerIds(): array
    {
        return $this->ownerIds;
    }

    public function setOwnerIds(array $ownerIds): Story
    {
        $this->ownerIds = $ownerIds;
        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(?int $position): Story
    {
        $this->position = $position;
        return $this;
    }

    public function getPreviousIterationIds(): array
    {
        return $this->previousIterationIds;
    }

    public function setPreviousIterationIds(array $previousIterationIds): Story
    {
        $this->previousIterationIds = $previousIterationIds;
        return $this;
    }

    public function getProjectId(): int
    {
        return $this->projectId;
    }

    public function setProjectId(int $projectId): Story
    {
        $this->projectId = $projectId;
        return $this;
    }

    public function getPullRequests(): array
    {
        return $this->pullRequests;
    }

    public function setPullRequests(array $pullRequests): Story
    {
        $this->pullRequests = $pullRequests;
        return $this;
    }

    public function getRequestedById(): ?string
    {
        return $this->requestedById;
    }

    public function setRequestedById(?string $requestedById): Story
    {
        $this->requestedById = $requestedById;
        return $this;
    }

    public function getStarted(): bool
    {
        return $this->started;
    }

    public function setStarted(bool $started): Story
    {
        $this->started = $started;
        return $this;
    }

    public function getStartedAt(): ?DateTime
    {
        return $this->startedAt;
    }

    public function setStartedAt(?DateTime $startedAt): Story
    {
        $this->startedAt = $startedAt;
        return $this;
    }

    public function getStartedAtOverride(): ?DateTime
    {
        return $this->startedAtOverride;
    }

    public function setStartedAtOverride(?DateTime $startedAtOverride): Story
    {
        $this->startedAtOverride = $startedAtOverride;
        return $this;
    }

    public function getStats(): array
    {
        return $this->stats;
    }

    public function setStats(array $stats): Story
    {
        $this->stats = $stats;
        return $this;
    }

    public function getStoryLinks(): array
    {
        return $this->storyLinks;
    }

    public function setStoryLinks(array $storyLinks): Story
    {
        $this->storyLinks = $storyLinks;
        return $this;
    }

    public function getStoryType(): string
    {
        return $this->storyType;
    }

    public function setStoryType(string $storyType): Story
    {
        $allowedTypes = [
            self::STORY_TYPE_CHORE,
            self::STORY_TYPE_BUG,
            self::STORY_TYPE_FEATURE
        ];

        if (!\in_array($storyType, $allowedTypes)) {
            throw new \DomainException('Story type does not exist');
        }
        $this->storyType = $storyType;
        return $this;
    }

    public function getTasks(): array
    {
        return $this->tasks;
    }

    public function setTasks(array $tasks): Story
    {
        $this->tasks = $tasks;
        return $this;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTime $updatedAt): Story
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getWorkflowStateId(): ?int
    {
        return $this->workflowStateId;
    }

    public function setWorkflowStateId(?int $workflowStateId): Story
    {
        $this->workflowStateId = $workflowStateId;
        return $this;
    }

    public function getAppUrl(): string
    {
        return $this->appUrl;
    }

    public function setAppUrl(string $appUrl): Story
    {
        $this->appUrl = $appUrl;
        return $this;
    }

    public function getCycleTime(): ?int
    {
        return $this->cycleTime;
    }

    public function setCycleTime(?int $cycleTime): Story
    {
        $this->cycleTime = $cycleTime;
        return $this;
    }

    public function getAfterStory(): ?int
    {
        return $this->afterStory;
    }

    public function setAfterStory(?int $afterStory): Story
    {
        $this->afterStory = $afterStory;
        return $this;
    }

    public function getBeforeStory(): ?int
    {
        return $this->beforeStory;
    }

    public function setBeforeStory(?int $beforeStory): Story
    {
        $this->beforeStory = $beforeStory;
        return $this;
    }
}
