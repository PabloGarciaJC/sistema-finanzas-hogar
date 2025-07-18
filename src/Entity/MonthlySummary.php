<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "monthly_summary")]
class MonthlySummary
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "integer")]
    private int $month;

    #[ORM\Column(type: "integer")]
    private int $year;

    #[ORM\Column(type: "float")]
    private float $totalIncome;

    #[ORM\Column(type: "float")]
    private float $savings = 0.0;

    #[ORM\Column(type: "float")]
    private float $debtTotal;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getTotalIncome(): float
    {
        return $this->totalIncome;
    }

    public function setTotalIncome(float $totalIncome): self
    {
        $this->totalIncome = $totalIncome;
        return $this;
    }

    public function getSavings(): float
    {
        return $this->savings;
    }

    public function setSavings(float $savings): self
    {
        $this->savings = $savings;
        return $this;
    }

    public function getDebtTotal(): float
    {
        return $this->debtTotal;
    }

    public function setDebtTotal(float $debtTotal): self
    {
        $this->debtTotal = $debtTotal;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;
        return $this;
    }
}
