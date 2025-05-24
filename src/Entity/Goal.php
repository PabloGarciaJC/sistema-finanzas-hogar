<?php

namespace App\Entity;

use App\Repository\GoalRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GoalRepository::class)]
class Goal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Member::class, inversedBy: "goals")]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Member $member = null;

    #[ORM\Column(type: 'text')]
    private string $description;

    #[ORM\Column(type: 'decimal', precision: 12, scale: 2)]
    private string $targetAmount;

    #[ORM\Column(type: 'string', length: 20)]
    private string $frequency;

    #[ORM\Column(type: 'date')]
    private \DateTimeInterface $startDate;

    #[ORM\Column(type: 'string', length: 20, options: ['default' => 'In progress'])]
    private string $status = 'In progress';

    public function __construct()
    {
        $this->startDate = new \DateTimeImmutable();
    }

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

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getTargetAmount(): string
    {
        return $this->targetAmount;
    }

    public function setTargetAmount(string $targetAmount): self
    {
        $this->targetAmount = $targetAmount;
        return $this;
    }

    public function getFrequency(): string
    {
        return $this->frequency;
    }

    public function setFrequency(string $frequency): self
    {
        $allowed = ['Mensual', 'Trimestral', 'Semestral', 'Anual'];
        if (!in_array($frequency, $allowed)) {
            throw new \InvalidArgumentException('Valor de frecuencia no válido');
        }
        $this->frequency = $frequency;
        return $this;
    }

    public function getStartDate(): \DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;
        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $allowed = ['Activo', 'Cancelado'];
        if (!in_array($status, $allowed)) {
            throw new \InvalidArgumentException("Invalid status value");
        }
        $this->status = $status;
        return $this;
    }

    // --- MÉTODOS AUXILIARES PARA MES Y AÑO ---

    public function getMonth(): ?int
    {
        return $this->startDate ? (int) $this->startDate->format('m') : null;
    }

    public function setMonth(int $month): self
    {
        $year = $this->startDate ? (int) $this->startDate->format('Y') : (int) date('Y');
        $this->startDate = new \DateTimeImmutable("$year-$month-01");
        return $this;
    }

    public function getYear(): ?int
    {
        return $this->startDate ? (int) $this->startDate->format('Y') : null;
    }

    public function setYear(int $year): self
    {
        $month = $this->startDate ? (int) $this->startDate->format('m') : 1;
        $this->startDate = new \DateTimeImmutable("$year-$month-01");
        return $this;
    }
}
