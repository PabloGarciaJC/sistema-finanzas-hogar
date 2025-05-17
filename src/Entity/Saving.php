<?php

namespace App\Entity;

use App\Repository\SavingRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SavingRepository::class)]
class Saving
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(options: ['unsigned' => true])]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Member::class, inversedBy: 'savings')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Member $member = null;

    #[ORM\Column(length: 20)]
    private ?string $month = null;

    #[ORM\Column]
    private ?int $year = null;

    #[ORM\Column(type: 'decimal', precision: 12, scale: 2)]
    private ?string $amount = null;

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

    public function getMonth(): ?string
    {
        return $this->month;
    }

    public function setMonth(string $month): self
    {
        $this->month = $month;
        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;
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
}
