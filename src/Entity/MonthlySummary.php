<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'monthly_summary')]
class MonthlySummary
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', options: ['unsigned' => true])]
    private ?int $id = null;

    #[ORM\Column(type: 'integer')]
    private int $month;

    #[ORM\Column(type: 'integer')]
    private int $year;

    #[ORM\Column(name: 'total_income', type: 'decimal', precision: 12, scale: 2)]
    private float $totalIncome;

    #[ORM\Column(type: 'decimal', precision: 12, scale: 2)]
    private float $savings;

    // ¡OJO! La columna tiene un typo: "menber"
    #[ORM\Column(name: 'bank_debt_menber_one', type: 'decimal', precision: 12, scale: 2)]
    private float $bankDebtMenberOne;

    #[ORM\Column(name: 'bank_debt_member_two', type: 'decimal', precision: 12, scale: 2)]
    private float $bankDebtMemberTwo;

    // Getters y setters

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

    public function getBankDebtMenberOne(): float
    {
        return $this->bankDebtMenberOne;
    }

    public function setBankDebtMenberOne(float $bankDebtMenberOne): self
    {
        $this->bankDebtMenberOne = $bankDebtMenberOne;
        return $this;
    }

    public function getBankDebtMemberTwo(): float
    {
        return $this->bankDebtMemberTwo;
    }

    public function setBankDebtMemberTwo(float $bankDebtMemberTwo): self
    {
        $this->bankDebtMemberTwo = $bankDebtMemberTwo;
        return $this;
    }
}
