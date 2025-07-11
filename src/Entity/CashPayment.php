<?php

namespace App\Entity;

use App\Repository\CashPaymentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CashPaymentRepository::class)]
#[ORM\Table(name: 'cash_payment')]
class CashPayment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(options: ['unsigned' => true])]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Member::class, inversedBy: 'incomes')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Member $member = null;

    #[ORM\Column(type: 'decimal', precision: 12, scale: 2)]
    private ?string $amount = '0.00';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: 'boolean', options: ['default' => true])]
    private bool $status = true; // true = activo

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?User $user = null;

    #[ORM\Column(type: 'integer')]
    private ?int $month = null;

    #[ORM\Column(type: 'integer')]
    private ?int $year = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $paymentDay = null;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
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

    public function getMonth(): ?int
    {
        return $this->month;
    }

    public function setMonth(int $month): self
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

    public function getPaymentDay(): ?int
    {
        return $this->paymentDay;
    }

    public function setPaymentDay(?int $paymentDay): self
    {
        $this->paymentDay = $paymentDay;
        return $this;
    }
}
