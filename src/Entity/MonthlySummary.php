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
    private float $savings;

    #[ORM\Column(type: "float")]
    private float $debtTotal;

    #[ORM\Column(type: "json")]
    private array $bankBalance = [];

    #[ORM\Column(type: "json")]
    private array $services = [];

    #[ORM\Column(type: "json")]
    private array $cashPayment = [];

    #[ORM\Column(type: "json")]
    private array $credit = [];

    #[ORM\Column(type: "json")]
    private array $goal = [];

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

    public function getBankBalance(): array
    {
        return $this->bankBalance;
    }

    public function setBankBalance(array $bankBalance): self
    {
        $this->bankBalance = $bankBalance;
        return $this;
    }

    public function getServices(): array
    {
        return $this->services;
    }

    public function setServices(array $services): self
    {
        $this->services = $services;
        return $this;
    }

    public function getCashPayment(): array
    {
        return $this->cashPayment;
    }

    public function setCashPayment(array $cashPayment): self
    {
        $this->cashPayment = $cashPayment;
        return $this;
    }

    public function getCredit(): array
    {
        return $this->credit;
    }

    public function setCredit(array $credit): self
    {
        $this->credit = $credit;
        return $this;
    }

    public function getGoal(): array
    {
        return $this->goal;
    }

    public function setGoal(array $goal): self
    {
        $this->goal = $goal;
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
