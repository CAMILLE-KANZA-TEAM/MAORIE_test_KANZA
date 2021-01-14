<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TaskRepository::class)
 */
class Task
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\OneToMany(targetEntity=TaskXStatus::class, mappedBy="task", orphanRemoval=true)
     */
    private $taskXStatuses;

    public function __construct()
    {
        $this->taskXStatuses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(?\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getUpdated(): ?\DateTimeInterface
    {
        return $this->updated;
    }

    public function setUpdated(?\DateTimeInterface $updated): self
    {
        $this->updated = $updated;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * @return Collection|TaskXStatus[]
     */
    public function getTaskXStatuses(): Collection
    {
        return $this->taskXStatuses;
    }

    public function addTaskXStatus(TaskXStatus $taskXStatus): self
    {
        if (!$this->taskXStatuses->contains($taskXStatus)) {
            $this->taskXStatuses[] = $taskXStatus;
            $taskXStatus->setTask($this);
        }

        return $this;
    }

    public function removeTaskXStatus(TaskXStatus $taskXStatus): self
    {
        if ($this->taskXStatuses->removeElement($taskXStatus)) {
            // set the owning side to null (unless already changed)
            if ($taskXStatus->getTask() === $this) {
                $taskXStatus->setTask(null);
            }
        }

        return $this;
    }
}
