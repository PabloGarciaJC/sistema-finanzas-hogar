<?php

namespace App\Entity;

use App\Repository\IncomeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IncomeRepository::class)]
#[ORM\Table(name: "income")]
class Income
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer", options: ['unsigned' => true])]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Member::class, inversedBy: "incomes")]
    #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE")]
    private ?Member $member = null;

    #[ORM\Column(type: "decimal", precision: 12, scale: 2)]
    private ?string $amount = null;

    #[ORM\Column(type: "integer")]
    private int $month;

    #[ORM\Column(type: "integer")]
    private int $year;

    #[ORM\Column(type: "boolean", options: ["default" => true])]
    private bool $status = true;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE")]
    private ?User $user = null;

    // Getters y Setters

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

    public function getAmount(): ?string
    {
        return $this->amount;
    }

    public function setAmount(string $amount): self
    {
        $this->amount = $amount;
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

    public function isStatus(): bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;
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
