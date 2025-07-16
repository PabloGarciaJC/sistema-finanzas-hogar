<?php

namespace App\Entity;

use App\Repository\CreditRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CreditRepository::class)]
class Credit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', options: ['unsigned' => true])]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Member::class, inversedBy: 'credits')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Member $member = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?User $user = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $bankEntity = null;

    #[ORM\Column(type: 'decimal', precision: 12, scale: 2)]
    private ?string $totalAmount = '0.00';

    #[ORM\Column(type: 'decimal', precision: 12, scale: 2)]
    private ?string $installmentAmount = '0.00';

    #[ORM\Column(type: 'string', length: 20)]
    private ?string $frequency = 'Mensual';

    #[ORM\Column(type: 'boolean', options: ['default' => false])]
    private bool $isPaid = false;

    #[ORM\Column(type: 'boolean', options: ['default' => true])]
    private bool $status = true;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;
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

    public function getInstallmentAmount(): ?string
    {
        return $this->installmentAmount;
    }

    public function setInstallmentAmount(string $installmentAmount): self
    {
        $this->installmentAmount = $installmentAmount;
        return $this;
    }

    public function getFrequency(): ?string
    {
        return $this->frequency;
    }

    public function setFrequency(string $frequency): self
    {
        $allowed = ['Mensual', 'Bimestral', 'Trimestral', 'Anual'];
        if (!in_array($frequency, $allowed)) {
            throw new \InvalidArgumentException("Frecuencia inválida: $frequency");
        }
        $this->frequency = $frequency;
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

    public function getIsPaid(): bool
    {
        return $this->isPaid;
    }

    public function setIsPaid(bool $isPaid): self
    {
        $this->isPaid = $isPaid;
        return $this;
    }
}
