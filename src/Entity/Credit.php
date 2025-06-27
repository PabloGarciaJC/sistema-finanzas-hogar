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

    #[ORM\Column(type: 'integer', options: ['unsigned' => true])]
    private ?int $installments = 1;

    #[ORM\Column(type: 'string', length: 20)]
    private ?string $frequency = 'Mensual';

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $startDate = null;

    #[ORM\Column(type: 'decimal', precision: 12, scale: 2, nullable: true)]
    private ?string $remainingAmount = null;

    #[ORM\Column(type: 'string', length: 20, options: ['default' => 'Activo'])]
    private ?string $status = 'Activo';

    // --- GETTERS Y SETTERS ---

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

    public function getInstallments(): ?int
    {
        return $this->installments;
    }

    public function setInstallments(int $installments): self
    {
        $this->installments = $installments;
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

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;
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
        $allowed = ['Activo', 'Cancelado'];
        if (!in_array($status, $allowed)) {
            throw new \InvalidArgumentException("Estado inválido: $status");
        }
        $this->status = $status;
        return $this;
    }

    // --- Métodos auxiliares para formulario (Mes/Año) ---

    public function getMonth(): ?int
    {
        return $this->startDate ? (int) $this->startDate->format('m') : null;
    }

    public function setMonth(?int $month): self
    {
        if ($month === null) {
            return $this;
        }
        $year = $this->startDate ? (int) $this->startDate->format('Y') : (int) date('Y');
        $this->startDate = new \DateTimeImmutable("$year-$month-01");
        return $this;
    }

    public function getYear(): ?int
    {
        return $this->startDate ? (int) $this->startDate->format('Y') : null;
    }

    public function setYear(?int $year): self
    {
        if ($year === null) {
            return $this;
        }
        $month = $this->startDate ? (int) $this->startDate->format('m') : 1;
        $this->startDate = new \DateTimeImmutable("$year-$month-01");
        return $this;
    }
}
