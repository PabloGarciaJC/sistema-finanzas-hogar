<?php

namespace App\Entity;

use App\Repository\IncomeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IncomeRepository::class)]
class Income
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(options: ['unsigned' => true])]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Member::class, inversedBy: 'incomes')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Member $member = null;

    #[ORM\Column(type: 'decimal', precision: 12, scale: 2)]
    private ?string $amount = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: 'string', length: 20, options: ['default' => 'Activo'])]
    private ?string $status = 'Activo';

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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;
        return $this;
    }

    // Métodos auxiliares para mes y año (usados en el formulario)

    public function getMonth(): ?int
    {
        return $this->date ? (int) $this->date->format('m') : null;
    }

    public function setMonth(int $month): self
    {
        $year = $this->date ? (int) $this->date->format('Y') : (int) date('Y');
        $this->date = new \DateTimeImmutable("$year-$month-01");
        return $this;
    }

    public function getYear(): ?int
    {
        return $this->date ? (int) $this->date->format('Y') : null;
    }

    public function setYear(int $year): self
    {
        $month = $this->date ? (int) $this->date->format('m') : 1;
        $this->date = new \DateTimeImmutable("$year-$month-01");
        return $this;
    }

    public function getStatus(): ?string
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
}
