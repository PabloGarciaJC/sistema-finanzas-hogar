<?php

namespace App\Entity;

use App\Repository\GoalRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GoalRepository::class)]
class Goal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(options: ['unsigned' => true])]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Member::class, inversedBy: 'goals')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Member $member = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: 'decimal', precision: 12, scale: 2)]
    private ?string $targetAmount = null;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private ?string $targetMonth = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $targetYear = null;

    #[ORM\Column(type: 'string', length: 20, options: ['default' => 'In progress'])]
    private ?string $status = 'In progress';

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMember(): ?Member
    {
        return $this->member;
    }

    public function setMember(?Member $member): self
    {
        $this->member = $member;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTargetAmount(): ?string
    {
        return $this->targetAmount;
    }

    public function setTargetAmount(string $targetAmount): self
    {
        $this->targetAmount = $targetAmount;

        return $this;
    }

    public function getTargetMonth(): ?string
    {
        return $this->targetMonth;
    }

    public function setTargetMonth(?string $targetMonth): self
    {
        $this->targetMonth = $targetMonth;

        return $this;
    }

    public function getTargetYear(): ?int
    {
        return $this->targetYear;
    }

    public function setTargetYear(?int $targetYear): self
    {
        $this->targetYear = $targetYear;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $allowed = ['In progress', 'Completed', 'Canceled'];
        if (!in_array($status, $allowed)) {
            throw new \InvalidArgumentException("Invalid status value");
        }
        $this->status = $status;

        return $this;
    }
}
