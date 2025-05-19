<?php

namespace App\Entity;

use App\Repository\MonthlySummaryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MonthlySummaryRepository::class)]
class MonthlySummary
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Member::class)]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Member $member = null;

    #[ORM\Column(type: 'integer')]
    private int $month;

    #[ORM\Column(type: 'integer')]
    private int $year;

    #[ORM\Column(type: 'decimal', precision: 12, scale: 2)]
    private string $totalIncome;

    #[ORM\Column(type: 'decimal', precision: 12, scale: 2)]
    private string $totalDebt;

    #[ORM\Column(type: 'decimal', precision: 12, scale: 2)]
    private string $savings;

    #[ORM\Column(type: 'decimal', precision: 12, scale: 2)]
    private string $balance;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $notes = null;

    // Getters y setters...

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

    public function getMonth(): int
    {
        return $this->month;
    }

    public function setMonth(int $month): self
    {
        $this->month = $month;
        return $this;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;
        return $this;
    }

    public function getTotalIncome(): string
    {
        return $this->totalIncome;
    }

    public function setTotalIncome(string $totalIncome): self
    {
        $this->totalIncome = $totalIncome;
        return $this;
    }

    public function getTotalDebt(): string
    {
        return $this->totalDebt;
    }

    public function setTotalDebt(string $totalDebt): self
    {
        $this->totalDebt = $totalDebt;
        return $this;
    }

    public function getSavings(): string
    {
        return $this->savings;
    }

    public function setSavings(string $savings): self
    {
        $this->savings = $savings;
        return $this;
    }

    public function getBalance(): string
    {
        return $this->balance;
    }

    public function setBalance(string $balance): self
    {
        $this->balance = $balance;
        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): self
    {
        $this->notes = $notes;
        return $this;
    }
}
