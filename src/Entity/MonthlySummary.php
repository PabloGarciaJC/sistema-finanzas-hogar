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

    #[ORM\Column(type: "float", nullable: true)]
    private ?float $bankDebtMemberOne = null;

    #[ORM\Column(type: "float", nullable: true)]
    private ?float $bankDebtMemberTwo = null;

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

    public function getBankDebtMemberOne(): ?float
    {
        return $this->bankDebtMemberOne;
    }

    public function setBankDebtMemberOne(?float $bankDebtMemberOne): self
    {
        $this->bankDebtMemberOne = $bankDebtMemberOne;
        return $this;
    }

    public function getBankDebtMemberTwo(): ?float
    {
        return $this->bankDebtMemberTwo;
    }

    public function setBankDebtMemberTwo(?float $bankDebtMemberTwo): self
    {
        $this->bankDebtMemberTwo = $bankDebtMemberTwo;
        return $this;
    }

    public function getRemainingBalance(): float
    {
        return ($this->totalIncome ?? 0) - ($this->debtTotal ?? 0) - ($this->savings ?? 0);
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
