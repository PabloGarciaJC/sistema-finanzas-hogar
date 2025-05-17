<?php

namespace App\Entity;

use App\Repository\CreditRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CreditRepository::class)]
class Credit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', options: ['unsigned' => true])]
    private ?int $id = null;

    // Relación ManyToOne con Member (muchos créditos pueden ser de un mismo miembro)
    #[ORM\ManyToOne(targetEntity: Member::class, inversedBy: 'credits')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Member $member = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $bankEntity = null;

    #[ORM\Column(type: 'decimal', precision: 12, scale: 2)]
    private ?string $totalAmount = null;

    #[ORM\Column(type: 'string', length: 20)]
    private ?string $frequency = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $startDate = null;

    #[ORM\Column(type: 'decimal', precision: 12, scale: 2)]
    private ?string $monthlyPayment = null;

    #[ORM\Column(type: 'decimal', precision: 12, scale: 2, nullable: true)]
    private ?string $remainingAmount = null;

    #[ORM\Column(type: 'string', length: 20, options: ['default' => 'Active'])]
    private ?string $status = 'Active';

    // Getters y Setters abajo...

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

    public function getBankEntity(): ?string
    {
        return $this->bankEntity;
    }

    public function setBankEntity(string $bankEntity): self
    {
        $this->bankEntity = $bankEntity;

        return $this;
    }

    public function getTotalAmount(): ?string
    {
        return $this->totalAmount;
    }

    public function setTotalAmount(string $totalAmount): self
    {
        $this->totalAmount = $totalAmount;

        return $this;
    }

    public function getFrequency(): ?string
    {
        return $this->frequency;
    }

    public function setFrequency(string $frequency): self
    {
        $allowed = ['Monthly', 'Bimonthly', 'Quarterly'];
        if (!in_array($frequency, $allowed)) {
            throw new \InvalidArgumentException("Invalid frequency value");
        }
        $this->frequency = $frequency;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getMonthlyPayment(): ?string
    {
        return $this->monthlyPayment;
    }

    public function setMonthlyPayment(string $monthlyPayment): self
    {
        $this->monthlyPayment = $monthlyPayment;

        return $this;
    }

    public function getRemainingAmount(): ?string
    {
        return $this->remainingAmount;
    }

    public function setRemainingAmount(?string $remainingAmount): self
    {
        $this->remainingAmount = $remainingAmount;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $allowed = ['Active', 'Paid', 'Canceled'];
        if (!in_array($status, $allowed)) {
            throw new \InvalidArgumentException("Invalid status value");
        }
        $this->status = $status;

        return $this;
    }
}
